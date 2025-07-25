<!-- Modal Alergi -->
<div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alergiModalLabel">Manajemen Data Alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Input Alergi -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Tambah Data Alergi</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modal_jenis_alergi" class="form-label">Jenis Alergi</label>
                                <select class="form-select" id="modal_jenis_alergi">
                                    <option value="">-- Pilih Jenis Alergi --</option>
                                    <option value="Obat">Obat</option>
                                    <option value="Makanan">Makanan</option>
                                    <option value="Udara">Udara</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_alergen" class="form-label">Alergen</label>
                                <input type="text" class="form-control" id="modal_alergen"
                                    placeholder="Contoh: Paracetamol, Seafood, Debu">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_reaksi" class="form-label">Reaksi</label>
                                <input type="text" class="form-control" id="modal_reaksi"
                                    placeholder="Contoh: Gatal, Ruam, Sesak nafas">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_tingkat_keparahan" class="form-label">Tingkat Keparahan</label>
                                <select class="form-select" id="modal_tingkat_keparahan">
                                    <option value="">-- Pilih Tingkat Keparahan --</option>
                                    <option value="Ringan">Ringan</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Berat">Berat</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary btn-sm" id="addToAlergiList">
                                <i class="bi bi-plus"></i> Tambah ke Daftar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Daftar Alergi -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Daftar Alergi Pasien</h6>
                        <span class="badge bg-primary" id="alergiCount">0</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th width="20%">Jenis Alergi</th>
                                        <th width="25%">Alergen</th>
                                        <th width="25%">Reaksi</th>
                                        <th width="20%">Tingkat Keparahan</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="modalAlergiList">
                                    <!-- Data akan ditampilkan di sini -->
                                </tbody>
                            </table>
                        </div>
                        <div id="noAlergiMessage" class="text-center text-muted py-3" style="display: none;">
                            <i class="bi bi-info-circle"></i> Belum ada data alergi
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveAlergiData">
                    <i class="bi bi-check"></i> Simpan Data Alergi
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            //====================================================================================//
            // ALERGI - EDIT MODE
            //====================================================================================//

            // Array untuk menyimpan data alergi sementara
            let alergiDataArray = [];

            // Load existing alergi data from PHP
            try {
                const existingAlergiData = @json($alergiPasien ?? []);
                alergiDataArray = existingAlergiData.map(item => ({
                    jenis_alergi: item.jenis_alergi || '',
                    alergen: item.nama_alergi || '',
                    reaksi: item.reaksi || '',
                    tingkat_keparahan: item.tingkat_keparahan || '',
                    is_existing: true,
                    id: item.id || null
                }));
            } catch (e) {
                console.log('Data alergi tidak tersedia');
                alergiDataArray = [];
            }

            // Event listeners untuk alergi
            const openAlergiModal = document.getElementById('openAlergiModal');
            if (openAlergiModal) {
                openAlergiModal.addEventListener('click', function() {
                    updateModalAlergiList();
                });
            }

            const addToAlergiList = document.getElementById('addToAlergiList');
            if (addToAlergiList) {
                addToAlergiList.addEventListener('click', function() {
                    const jenisAlergi = document.getElementById('modal_jenis_alergi')?.value?.trim();
                    const alergen = document.getElementById('modal_alergen')?.value?.trim();
                    const reaksi = document.getElementById('modal_reaksi')?.value?.trim();
                    const tingkatKeparahan = document.getElementById('modal_tingkat_keparahan')?.value
                        ?.trim();

                    if (!jenisAlergi || !alergen || !reaksi || !tingkatKeparahan) {
                        alert('Harap isi semua field alergi');
                        return;
                    }

                    const isDuplicate = alergiDataArray.some(item =>
                        item.jenis_alergi === jenisAlergi &&
                        item.alergen.toLowerCase() === alergen.toLowerCase()
                    );

                    if (isDuplicate) {
                        alert('Data alergi sudah ada');
                        return;
                    }

                    alergiDataArray.push({
                        jenis_alergi: jenisAlergi,
                        alergen: alergen,
                        reaksi: reaksi,
                        tingkat_keparahan: tingkatKeparahan,
                        is_existing: false
                    });

                    updateModalAlergiList();
                    resetAlergiForm();
                });
            }

            const saveAlergiData = document.getElementById('saveAlergiData');
            if (saveAlergiData) {
                saveAlergiData.addEventListener('click', function() {
                    updateMainAlergiTable();
                    updateHiddenAlergiInput();

                    const alergiModal = document.getElementById('alergiModal');
                    if (alergiModal && typeof bootstrap !== 'undefined') {
                        const modalInstance = bootstrap.Modal.getInstance(alergiModal);
                        if (modalInstance) modalInstance.hide();
                    }
                });
            }

            // Functions untuk alergi
            function updateModalAlergiList() {
                const tbody = document.getElementById('modalAlergiList');
                const noDataMessage = document.getElementById('noAlergiMessage');
                const countBadge = document.getElementById('alergiCount');

                if (!tbody) return;

                tbody.innerHTML = '';

                if (alergiDataArray.length === 0) {
                    if (noDataMessage) noDataMessage.style.display = 'block';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'none';
                } else {
                    if (noDataMessage) noDataMessage.style.display = 'none';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'table';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeAlergiFromModal(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                                ${item.is_existing ? '<small class="text-muted d-block">Dari DB</small>' : '<small class="text-success d-block">Baru</small>'}
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }

                if (countBadge) countBadge.textContent = alergiDataArray.length;
            }

            function updateMainAlergiTable() {
                const tbody = document.querySelector('#createAlergiTable tbody');
                const noAlergiRow = document.getElementById('no-alergi-row');

                if (!tbody || !noAlergiRow) return;

                const existingRows = tbody.querySelectorAll('tr:not(#no-alergi-row)');
                existingRows.forEach(row => row.remove());

                if (alergiDataArray.length === 0) {
                    noAlergiRow.style.display = 'table-row';
                } else {
                    noAlergiRow.style.display = 'none';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAlergiFromMain(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }
            }

            function updateHiddenAlergiInput() {
                const hiddenInput = document.getElementById('alergisInput');
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(alergiDataArray);
                }
            }

            function resetAlergiForm() {
                const fields = ['modal_jenis_alergi', 'modal_alergen', 'modal_reaksi', 'modal_tingkat_keparahan'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
            }

            function getKeparahanBadgeClass(keparahan) {
                switch (keparahan.toLowerCase()) {
                    case 'ringan':
                        return 'bg-success';
                    case 'sedang':
                        return 'bg-warning';
                    case 'berat':
                        return 'bg-danger';
                    default:
                        return 'bg-secondary';
                }
            }

            // Global functions untuk onclick events
            window.removeAlergiFromModal = function(index) {
                alergiDataArray.splice(index, 1);
                updateModalAlergiList();
            };

            window.removeAlergiFromMain = function(index) {
                alergiDataArray.splice(index, 1);
                updateMainAlergiTable();
                updateHiddenAlergiInput();
            };

            // Initial load untuk alergi
            updateMainAlergiTable();
            updateHiddenAlergiInput();

            // PERBAIKAN: Pemeriksaan Fisik Logic
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const targetDiv = document.getElementById(targetId);
                    const itemId = targetId.replace('-keterangan', '');
                    const checkbox = document.querySelector(`input[name="${itemId}-normal"]`);

                    if (targetDiv.style.display === 'none' || targetDiv.style.display === '') {
                        targetDiv.style.display = 'block';
                        // Uncheck normal when adding keterangan
                        if (checkbox) checkbox.checked = false;
                    } else {
                        targetDiv.style.display = 'none';
                        // Clear the input when hiding
                        const input = targetDiv.querySelector('input');
                        if (input) input.value = '';
                    }
                });
            });

            // PERBAIKAN: Handle normal checkbox changes
            document.querySelectorAll('input[type="checkbox"][id$="-normal"]').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const itemId = this.id.replace('-normal', '');
                    const keteranganDiv = document.getElementById(itemId + '-keterangan');
                    const keteranganInput = keteranganDiv ? keteranganDiv.querySelector('input') : null;

                    if (this.checked) {
                        // Hide keterangan when normal is checked
                        if (keteranganDiv) {
                            keteranganDiv.style.display = 'none';
                            if (keteranganInput) keteranganInput.value = '';
                        }
                    }
                });
            });

            // PERBAIKAN: Function to toggle input fields based on radio button selection
            function toggleInputFields(radioName, inputIds, yesValue = 'ya') {
                const radios = document.getElementsByName(radioName);
                const inputs = inputIds.map(id => document.getElementById(id)).filter(input => input !== null);

                // Initialize state based on current selection
                const selectedValue = Array.from(radios).find(radio => radio.checked)?.value;
                inputs.forEach(input => {
                    input.disabled = selectedValue !== yesValue;
                });

                // Add event listeners to radio buttons
                radios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        inputs.forEach(input => {
                            input.disabled = this.value !== yesValue;
                            if (this.value !== yesValue) {
                                input.value = ''; // Clear input when disabled
                                input.classList.remove('is-invalid');
                            }
                        });
                    });
                });
            }

            // Toggle inputs for Merokok
            toggleInputFields('merokok', ['merokok_jumlah', 'merokok_lama']);

            // Toggle inputs for Alkohol
            toggleInputFields('alkohol', ['alkohol_jumlah']);

            // Toggle inputs for Obat-obatan
            toggleInputFields('obat_obatan', ['obat_jenis']);

            // PERBAIKAN: Toggle 'lainnya' input based on checkbox
            const lainnyaCheck = document.getElementById('lainnya_check');
            const lainnyaInput = document.getElementById('lainnya');

            if (lainnyaCheck && lainnyaInput) {
                // Initialize state
                lainnyaInput.disabled = !lainnyaCheck.checked;

                // Add event listener to checkbox
                lainnyaCheck.addEventListener('change', function () {
                    lainnyaInput.disabled = !this.checked;
                    if (!this.checked) {
                        lainnyaInput.value = '';
                        lainnyaInput.classList.remove('is-invalid');
                    }
                });
            }

            // PERBAIKAN: Client-side validation on form submission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function (event) {
                    let errors = [];

                    // Check Merokok
                    const merokok = document.querySelector('input[name="merokok"]:checked')?.value;
                    if (merokok === 'ya') {
                        const jumlah = document.getElementById('merokok_jumlah');
                        const lama = document.getElementById('merokok_lama');

                        if (jumlah && (!jumlah.value || jumlah.value < 0)) {
                            errors.push('Jumlah batang/hari harus diisi dan tidak boleh negatif.');
                            jumlah.classList.add('is-invalid');
                        }
                        if (lama && (!lama.value || lama.value < 0)) {
                            errors.push('Lama merokok harus diisi dan tidak boleh negatif.');
                            lama.classList.add('is-invalid');
                        }
                    }

                    // Check Alkohol
                    const alkohol = document.querySelector('input[name="alkohol"]:checked')?.value;
                    const alkoholJumlah = document.getElementById('alkohol_jumlah');
                    if (alkohol === 'ya' && alkoholJumlah && !alkoholJumlah.value.trim()) {
                        errors.push('Jumlah konsumsi alkohol harus diisi.');
                        alkoholJumlah.classList.add('is-invalid');
                    }

                    // Check Obat-obatan
                    const obat = document.querySelector('input[name="obat_obatan"]:checked')?.value;
                    const obatJenis = document.getElementById('obat_jenis');
                    if (obat === 'ya' && obatJenis && !obatJenis.value.trim()) {
                        errors.push('Jenis obat-obatan harus diisi.');
                        obatJenis.classList.add('is-invalid');
                    }

                    // Validate 'lainnya' field
                    if (lainnyaCheck && lainnyaInput) {
                        if (lainnyaCheck.checked && !lainnyaInput.value.trim()) {
                            errors.push('Rencana lainnya wajib diisi jika dicentang.');
                            lainnyaInput.classList.add('is-invalid');
                        } else {
                            lainnyaInput.classList.remove('is-invalid');
                        }
                    }

                    // If there are errors, prevent form submission and show alert
                    if (errors.length > 0) {
                        event.preventDefault();
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Belum Lengkap',
                                html: errors.join('<br>'),
                                confirmButtonColor: '#3085d6',
                            });
                        } else {
                            alert('Data Belum Lengkap:\n' + errors.join('\n'));
                        }
                    }
                });
            }
        });
    </script>
@endpush