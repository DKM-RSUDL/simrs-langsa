<!-- Modal Alergi -->
<div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alergiModalLabel">Data Alergi Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the allergies data structure
            let allergies = [];

            // Load existing allergies from hidden input
            const allergiInput = document.getElementById('alergi');
            if (allergiInput && allergiInput.value) {
                try {
                    allergies = JSON.parse(allergiInput.value);
                    renderAlergiTable();
                } catch (e) {
                    console.error('Error parsing allergies JSON:', e);
                    allergies = [];
                }
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
                        <td>
                            ${alergi.jenis_alergi}
                        </td>
                        <td>${alergi.nama_alergi}</td>
                        <td>${alergi.reaksi || '-'}</td>
                        <td>${alergi.severe || '-'}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger delete-alergi" data-index="${index}">
                                <i class="ti-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);

                    alergenList += `<div>
                                        <input type="hidden" name="jenis_alergi[]" value="${alergi.jenis_alergi}">
                                        <input type="hidden" name="nama[]" value="${alergi.nama_alergi}">
                                        <input type="hidden" name="reaksi[]" value="${alergi.reaksi}">
                                        <input type="hidden" name="severe[]" value="${alergi.severe}">
                                    </div>`;

                });

                $('#alergen-list-input').html(alergenList);

                // Add event listeners to delete buttons
                document.querySelectorAll('.delete-alergi').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        allergies.splice(index, 1);
                        renderAlergiTable();
                        updateAlergiDisplay();
                    });
                });
            }

            // Function to update the allergies display in the main form
            function updateAlergiDisplay() {
                const allergiDisplay = document.getElementById('alergi_display');
                const allergiJson = document.getElementById('alergi');

                if (allergies.length > 0) {
                    const allergyNames = allergies.map(a => a.nama_alergi).join(', ');
                    allergiDisplay.value = allergyNames;
                    allergiJson.value = allergies;
                } else {
                    allergiDisplay.value = '';
                    allergiJson.value = '';
                }
            }

            // Add new allergy
            document.getElementById('tambahAlergi').addEventListener('click', function() {
                const tambahButton = this;
                tambahButton.disabled = true; // Disable button to prevent multiple clicks

                const jenisAlergi = document.getElementById('jenis_alergi').value;
                const namaAlergi = document.getElementById('nama_alergi').value.trim();
                const reaksi = document.getElementById('reaksi').value.trim();
                const severe = document.getElementById('severe').value;

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

                // Case-insensitive duplicate check
                const isDuplicate = allergies.some(a =>
                    a.jenis_alergi.toLowerCase() === jenisAlergi.toLowerCase() &&
                    a.nama_alergi.toLowerCase() === namaAlergi.toLowerCase()
                );

                if (isDuplicate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplikasi Data',
                        text: 'Alergi dengan jenis dan nama yang sama sudah ada',
                        confirmButtonColor: '#3085d6',
                    });
                    tambahButton.disabled = false;
                    return;
                }

                // Add to allergies array
                allergies.push({
                    jenis_alergi: jenisAlergi,
                    nama_alergi: namaAlergi,
                    reaksi: reaksi,
                    severe: severe
                });

                // Clear form inputs
                document.getElementById('jenis_alergi').value = '';
                document.getElementById('nama_alergi').value = '';
                document.getElementById('reaksi').value = '';
                document.getElementById('severe').value = '';

                // Update display
                renderAlergiTable();
                updateAlergiDisplay();
                tambahButton.disabled = false;
            });

            // Reset form when modal is closed
            $('#alergiModal').on('hidden.bs.modal', function() {
                document.getElementById('jenis_alergi').value = '';
                document.getElementById('nama_alergi').value = '';
                document.getElementById('reaksi').value = '';
                document.getElementById('severe').value = '';
            });

            // Initialize the allergies table when the modal is opened
            $('#alergiModal').on('show.bs.modal', function() {
                renderAlergiTable();
            });

            // Initial render if there are existing allergies
            if (allergies.length > 0) {
                updateAlergiDisplay();
            }
        });
    </script>
@endpush
