<!-- Modal Riwayat Obstetrik -->
<div class="modal fade" id="modalRiwayatObstetrik" tabindex="-1" aria-labelledby="modalRiwayatObstetrikLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalRiwayatObstetrikLabel">
                    <i class="bi bi-clipboard-plus me-2"></i>Tambah Riwayat Obstetrik
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>Lengkapi data riwayat obstetrik pasien.</div>
                    </div>
                </div>

                <form id="formRiwayatObstetrik">
                    <input type="hidden" id="riwayatObstetrikId" value="">
                    <input type="hidden" id="riwayatObstetrikIndex" value="">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="keadaanKehamilan" class="form-label">Keadaan Kehamilan</label>
                                <input type="text" class="form-control" id="keadaanKehamilan" placeholder="Jelaskan keadaan kehamilan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="caraPersalinan" class="form-label">Cara Persalinan</label>
                                <input type="text" class="form-control" id="caraPersalinan" placeholder="Jelaskan cara persalinan">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="keadaanNifas" class="form-label">Keadaan Nifas</label>
                                <input type="text" class="form-control" id="keadaanNifas" placeholder="Jelaskan keadaan nifas">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="tanggalLahir">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="keadaanAnak" class="form-label">Keadaan Anak</label>
                                <input type="text" class="form-control" id="keadaanAnak" placeholder="Jelaskan keadaan anak">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tempatDanPenolong" class="form-label">Tempat dan Penolong</label>
                                <input type="text" class="form-control" id="tempatDanPenolong" placeholder="Jelaskan tempat dan penolong">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnSimpanRiwayatObstetrik">
                    <i class="bi bi-check-lg me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize variables
            let riwayatObstetrikData = [];
            const modalRiwayatObstetrik = new bootstrap.Modal(document.getElementById('modalRiwayatObstetrik'));
            const btnRiwayatObstetrik = document.getElementById('btn-riwayat-obstetrik');
            const btnSimpanRiwayatObstetrik = document.getElementById('btnSimpanRiwayatObstetrik');
            const formRiwayatObstetrik = document.getElementById('formRiwayatObstetrik');
            const riwayatObstetrikId = document.getElementById('riwayatObstetrikId');
            const riwayatObstetrikIndex = document.getElementById('riwayatObstetrikIndex');
            const tableBody = document.querySelector('#tabelRiwayatObstetrik tbody');
            const hiddenInput = document.getElementById('riwayatObstetrikInput');

            // Function to parse data that might be in different formats
            function parseRiwayatObstetrikData(inputData) {
                if (!inputData) return [];

                try {
                    // Try to parse as JSON
                    if (typeof inputData === 'string') {
                        // Clean the string from any unwanted characters
                        const cleanedInput = inputData
                            .replace(/\\/g, '')    // Remove backslashes
                            .replace(/^\"/g, '')   // Remove opening quote
                            .replace(/\"$/g, '')   // Remove closing quote
                            .trim();

                        // If it's empty or just whitespace, return empty array
                        if (!cleanedInput || cleanedInput === '[]') return [];

                        // Try to parse as JSON
                        return JSON.parse(cleanedInput);
                    } else if (Array.isArray(inputData)) {
                        // Already an array
                        return inputData;
                    }
                } catch (error) {
                    console.error('Error parsing riwayat obstetrik data:', error);
                }

                // Default to empty array if parsing fails
                return [];
            }

            // Format date to DD/MM/YYYY
            function formatDate(dateString) {
                if (!dateString) return '';

                const date = new Date(dateString);
                if (isNaN(date.getTime())) return dateString; // Return as is if invalid

                return date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                }).replace(/-/g, '/');
            }

            // Format date from DD/MM/YYYY to YYYY-MM-DD for input
            function formatDateForInput(dateString) {
                if (!dateString) return '';

                // Check if it's already in YYYY-MM-DD format
                if (/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
                    return dateString;
                }

                const parts = dateString.split('/');
                if (parts.length !== 3) return '';

                return `${parts[2]}-${parts[1]}-${parts[0]}`;
            }

            // Load data from hidden input
            function loadInitialData() {
                // Start with empty array
                riwayatObstetrikData = [];

                // If there's data from the hidden input, use that
                if (hiddenInput && hiddenInput.value) {
                    try {
                        const parsedData = parseRiwayatObstetrikData(hiddenInput.value);
                        if (Array.isArray(parsedData) && parsedData.length > 0) {
                            riwayatObstetrikData = parsedData.map((item, index) => {
                                // Ensure each item has an id
                                return {
                                    ...item,
                                    id: item.id || `ro-${index + 1}`
                                };
                            });
                        }
                    } catch (e) {
                        console.error('Error parsing JSON data:', e);
                    }
                }
            }

            // Render table with current data
            function renderTable() {
                tableBody.innerHTML = '';

                riwayatObstetrikData.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.setAttribute('data-id', item.id);

                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${item.keadaanKehamilan || ''}</td>
                        <td>${item.caraPersalinan || ''}</td>
                        <td>${item.keadaanNifas || ''}</td>
                        <td>${item.tanggalLahir || ''}</td>
                        <td>${item.keadaanAnak || ''}</td>
                        <td>${item.tempatDanPenolong || ''}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary btn-edit-riwayat" data-id="${item.id}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-delete-riwayat" data-id="${item.id}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    `;

                    tableBody.appendChild(row);
                });

                // Update hidden input with JSON data
                hiddenInput.value = JSON.stringify(riwayatObstetrikData);

                // Add click handlers for edit and delete buttons
                document.querySelectorAll('.btn-edit-riwayat').forEach(btn => {
                    btn.addEventListener('click', handleEditRiwayat);
                });

                document.querySelectorAll('.btn-delete-riwayat').forEach(btn => {
                    btn.addEventListener('click', handleDeleteRiwayat);
                });
            }

            // Reset form fields
            function resetForm() {
                formRiwayatObstetrik.reset();
                riwayatObstetrikId.value = '';
                riwayatObstetrikIndex.value = '';
            }

            // Handle add button click
            btnRiwayatObstetrik.addEventListener('click', function() {
                resetForm();
                modalRiwayatObstetrik.show();
            });

            // Handle edit button click
            function handleEditRiwayat(e) {
                const id = e.currentTarget.getAttribute('data-id');
                const index = riwayatObstetrikData.findIndex(item => item.id === id);

                if (index !== -1) {
                    const item = riwayatObstetrikData[index];

                    // Populate form fields with data or empty string if undefined
                    document.getElementById('keadaanKehamilan').value = item.keadaanKehamilan || '';
                    document.getElementById('caraPersalinan').value = item.caraPersalinan || '';
                    document.getElementById('keadaanNifas').value = item.keadaanNifas || '';
                    document.getElementById('tanggalLahir').value = formatDateForInput(item.tanggalLahir || '');
                    document.getElementById('keadaanAnak').value = item.keadaanAnak || '';
                    document.getElementById('tempatDanPenolong').value = item.tempatDanPenolong || '';

                    // Set ID and index for reference
                    riwayatObstetrikId.value = id;
                    riwayatObstetrikIndex.value = index;

                    // Show modal
                    modalRiwayatObstetrik.show();
                }
            }

            // Handle delete button click
            function handleDeleteRiwayat(e) {
                const id = e.currentTarget.getAttribute('data-id');
                const index = riwayatObstetrikData.findIndex(item => item.id === id);

                if (index !== -1) {
                    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                        // Remove the data
                        riwayatObstetrikData.splice(index, 1);
                        renderTable();
                    }
                }
            }

            // Handle save button click
            btnSimpanRiwayatObstetrik.addEventListener('click', function() {
                // Get form values
                const keadaanKehamilan = document.getElementById('keadaanKehamilan').value;
                const caraPersalinan = document.getElementById('caraPersalinan').value;
                const keadaanNifas = document.getElementById('keadaanNifas').value;
                const tanggalLahir = document.getElementById('tanggalLahir').value;
                const keadaanAnak = document.getElementById('keadaanAnak').value;
                const tempatDanPenolong = document.getElementById('tempatDanPenolong').value;

                // Validate required fields
                if (!keadaanKehamilan || !caraPersalinan || !keadaanNifas || !tanggalLahir || !keadaanAnak || !tempatDanPenolong) {
                    alert('Semua field harus diisi!');
                    return;
                }

                // Format date for display
                const formattedDate = formatDate(tanggalLahir);

                // Check if editing or adding new
                const editIndex = parseInt(riwayatObstetrikIndex.value);
                if (!isNaN(editIndex) && editIndex >= 0 && editIndex < riwayatObstetrikData.length) {
                    // Update existing record
                    riwayatObstetrikData[editIndex] = {
                        id: riwayatObstetrikId.value,
                        keadaanKehamilan,
                        caraPersalinan,
                        keadaanNifas,
                        tanggalLahir: formattedDate,
                        keadaanAnak,
                        tempatDanPenolong
                    };
                } else {
                    // Add new record
                    riwayatObstetrikData.push({
                        id: `ro-${Date.now()}`,
                        keadaanKehamilan,
                        caraPersalinan,
                        keadaanNifas,
                        tanggalLahir: formattedDate,
                        keadaanAnak,
                        tempatDanPenolong
                    });
                }

                // Update table and close modal
                renderTable();
                modalRiwayatObstetrik.hide();
                resetForm();
            });

            // Initialize the table with existing data
            loadInitialData();

            // Render the table
            renderTable();
        });
    </script>
@endpush
