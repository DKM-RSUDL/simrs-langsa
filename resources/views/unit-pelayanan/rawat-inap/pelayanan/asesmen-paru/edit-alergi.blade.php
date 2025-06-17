<!-- Modal Alergi -->
<div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alergiModalLabel">Data Alergi Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_index" value="">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_alergi" class="form-label">Jenis Alergi</label>
                            <select class="form-select" id="jenis_alergi" name="jenis_alergi">
                                <option value="">Pilih Jenis Alergi</option>
                                <option value="Obat">Obat</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Udara">Udara</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_alergi" class="form-label">Alergen</label>
                            <input type="text" class="form-control" id="nama_alergi" name="nama_alergi"
                                placeholder="Masukkan nama alergen">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reaksi" class="form-label">Reaksi</label>
                            <input type="text" class="form-control" id="reaksi" name="reaksi"
                                placeholder="Masukkan reaksi yang timbul">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="severe" class="form-label">Tingkat Keparahan</label>
                            <select class="form-select" id="severe" name="severe">
                                <option value="">Pilih Tingkat Keparahan</option>
                                <option value="Ringan">Ringan</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Berat">Berat</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table to display existing allergies -->
                <div class="mt-4">
                    <h6>Daftar Alergi</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tableAlergi">
                            <thead class="bg-light">
                                <tr>
                                    <th>Jenis Alergi</th>
                                    <th>Alergen</th>
                                    <th>Reaksi</th>
                                    <th>Tingkat Keparahan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="alergiList">
                                <!-- Data will be loaded here via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="tambahAlergi">Tambah Alergi</button>
                <button type="button" class="btn btn-warning" id="updateAlergi" style="display: none;">Update
                    Alergi</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize the allergies data structure
            let allergies = [];

            // Load existing allergies from the model
            @if ($asesmen->rmeAlergiPasien)
                try {
                    allergies = @json($asesmen->rmeAlergiPasien);
                    renderAlergiTable();
                } catch (e) {
                    console.error('Error parsing allergies JSON:', e);
                    allergies = [];
                }
            @endif

            // Function to check if allergy already exists
            function checkDuplicateAllergy(jenisAlergi, namaAlergi, excludeIndex = -1) {
                return allergies.some((a, index) => {
                    if (excludeIndex !== -1 && index === excludeIndex) {
                        return false; // Skip the current item being edited
                    }
                    return a.jenis_alergi.toLowerCase().trim() === jenisAlergi.toLowerCase().trim() &&
                           a.nama_alergi.toLowerCase().trim() === namaAlergi.toLowerCase().trim();
                });
            }

            // Function to render allergi table
            function renderAlergiTable() {
                const tbody = document.getElementById('alergiList');
                tbody.innerHTML = '';

                if (allergies.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = '<td colspan="5" class="text-center">Belum ada data alergi</td>';
                    tbody.appendChild(row);
                    return;
                }

                let alergenList = '';

                allergies.forEach((alergi, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${alergi.jenis_alergi}</td>
                        <td>${alergi.nama_alergi}</td>
                        <td>${alergi.reaksi || '-'}</td>
                        <td>${alergi.tingkat_keparahan || '-'}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning edit-alergi" data-index="${index}">
                                <i class="ti-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger delete-alergi" data-index="${index}">
                                <i class="ti-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);

                    alergenList += `
                        <div>
                            <input type="hidden" name="jenis_alergi[]" value="${alergi.jenis_alergi}">
                            <input type="hidden" name="nama[]" value="${alergi.nama_alergi}">
                            <input type="hidden" name="reaksi[]" value="${alergi.reaksi || ''}">
                            <input type="hidden" name="severe[]" value="${alergi.tingkat_keparahan || ''}">
                        </div>
                    `;
                });

                const alergenListContainer = document.getElementById('alergen-list-input');
                if (alergenListContainer) {
                    alergenListContainer.innerHTML = alergenList;
                }

                // Add event listeners to edit and delete buttons
                document.querySelectorAll('.edit-alergi').forEach(button => {
                    button.addEventListener('click', function () {
                        const index = parseInt(this.getAttribute('data-index'));
                        const alergi = allergies[index];

                        // Populate form with existing data
                        document.getElementById('edit_index').value = index;
                        document.getElementById('jenis_alergi').value = alergi.jenis_alergi;
                        document.getElementById('nama_alergi').value = alergi.nama_alergi;
                        document.getElementById('reaksi').value = alergi.reaksi || '';
                        document.getElementById('severe').value = alergi.tingkat_keparahan || '';

                        // Show update button, hide add button
                        document.getElementById('tambahAlergi').style.display = 'none';
                        document.getElementById('updateAlergi').style.display = 'inline-block';
                    });
                });

                document.querySelectorAll('.delete-alergi').forEach(button => {
                    button.addEventListener('click', function () {
                        const index = parseInt(this.getAttribute('data-index'));
                        const alergiToDelete = allergies[index];

                        // Show confirmation before deleting
                        Swal.fire({
                            title: 'Konfirmasi Hapus',
                            text: `Apakah Anda yakin ingin menghapus alergi "${alergiToDelete.nama_alergi}"?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                allergies.splice(index, 1);
                                renderAlergiTable();
                                updateAlergiDisplay();

                                // Show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data alergi berhasil dihapus',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        });
                    });
                });
            }

            // Function to update the allergies display in the main form
            function updateAlergiDisplay() {
                const allergiDisplay = document.getElementById('alergi_display');
                if (allergiDisplay) {
                    if (allergies.length > 0) {
                        const allergyNames = allergies.map(a => a.nama_alergi).join(', ');
                        allergiDisplay.value = allergyNames;
                    } else {
                        allergiDisplay.value = '';
                    }
                }
            }

            // Add new allergy
            document.getElementById('tambahAlergi').addEventListener('click', function () {
                const tambahButton = this;
                tambahButton.disabled = true;

                const jenisAlergi = document.getElementById('jenis_alergi').value;
                const namaAlergi = document.getElementById('nama_alergi').value.trim();
                const reaksi = document.getElementById('reaksi').value.trim();
                const severe = document.getElementById('severe').value;

                // Validation: Check if required fields are filled
                if (!jenisAlergi || !namaAlergi) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Silakan isi Jenis Alergi dan Alergen terlebih dahulu',
                        confirmButtonColor: '#3085d6',
                    });
                    tambahButton.disabled = false;
                    return;
                }

                // Check for duplicate allergy
                if (checkDuplicateAllergy(jenisAlergi, namaAlergi)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplikasi Data',
                        text: `Alergi "${namaAlergi}" dengan jenis "${jenisAlergi}" sudah ada dalam daftar`,
                        confirmButtonColor: '#3085d6',
                    });
                    tambahButton.disabled = false;
                    return;
                }

                // Show confirmation before adding
                Swal.fire({
                    title: 'Konfirmasi',
                    text: `Apakah Anda yakin ingin menambahkan alergi "${namaAlergi}"?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Tambahkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Add to allergies array
                        allergies.push({
                            jenis_alergi: jenisAlergi,
                            nama_alergi: namaAlergi,
                            reaksi: reaksi,
                            tingkat_keparahan: severe
                        });

                        // Clear form inputs
                        clearForm();

                        // Update display
                        renderAlergiTable();
                        updateAlergiDisplay();

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data alergi berhasil ditambahkan',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                    tambahButton.disabled = false;
                });
            });

            // Update existing allergy
            document.getElementById('updateAlergi').addEventListener('click', function () {
                const updateButton = this;
                updateButton.disabled = true;

                const index = parseInt(document.getElementById('edit_index').value);
                const jenisAlergi = document.getElementById('jenis_alergi').value;
                const namaAlergi = document.getElementById('nama_alergi').value.trim();
                const reaksi = document.getElementById('reaksi').value.trim();
                const severe = document.getElementById('severe').value;

                // Validation: Check if required fields are filled
                if (!jenisAlergi || !namaAlergi) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Silakan isi Jenis Alergi dan Alergen terlebih dahulu',
                        confirmButtonColor: '#3085d6',
                    });
                    updateButton.disabled = false;
                    return;
                }

                // Check for duplicates (excluding the current index)
                if (checkDuplicateAllergy(jenisAlergi, namaAlergi, index)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplikasi Data',
                        text: `Alergi "${namaAlergi}" dengan jenis "${jenisAlergi}" sudah ada dalam daftar`,
                        confirmButtonColor: '#3085d6',
                    });
                    updateButton.disabled = false;
                    return;
                }

                // Show confirmation before updating
                Swal.fire({
                    title: 'Konfirmasi Update',
                    text: `Apakah Anda yakin ingin mengupdate data alergi "${namaAlergi}"?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Update',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Update the allergy
                        allergies[index] = {
                            jenis_alergi: jenisAlergi,
                            nama_alergi: namaAlergi,
                            reaksi: reaksi,
                            tingkat_keparahan: severe
                        };

                        // Clear form and reset buttons
                        clearForm();
                        document.getElementById('tambahAlergi').style.display = 'inline-block';
                        document.getElementById('updateAlergi').style.display = 'none';

                        // Update display
                        renderAlergiTable();
                        updateAlergiDisplay();

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data alergi berhasil diupdate',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                    updateButton.disabled = false;
                });
            });

            // Clear form inputs
            function clearForm() {
                document.getElementById('edit_index').value = '';
                document.getElementById('jenis_alergi').value = '';
                document.getElementById('nama_alergi').value = '';
                document.getElementById('reaksi').value = '';
                document.getElementById('severe').value = '';
            }

            // Reset form when modal is closed
            $('#alergiModal').on('hidden.bs.modal', function () {
                clearForm();
                document.getElementById('tambahAlergi').style.display = 'inline-block';
                document.getElementById('updateAlergi').style.display = 'none';
            });

            // Initialize the allergies table when the modal is opened
            $('#alergiModal').on('show.bs.modal', function () {
                renderAlergiTable();
            });

            // Initial render if there are existing allergies
            if (allergies.length > 0) {
                updateAlergiDisplay();
            }
        });
    </script>
@endpush
