<!-- Modal for Family Disease History Input -->
<div class="modal fade" id="modal-family-disease-history" tabindex="-1" aria-labelledby="familyDiseaseHistoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="familyDiseaseHistoryLabel">Input Riwayat Penyakit Keluarga</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="family-disease-input" class="form-label fw-bold">Tambah Penyakit Keluarga</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="family-disease-input"
                            placeholder="Masukkan nama penyakit keluarga">
                        <button class="btn btn-primary" type="button" id="btn-add-family-disease">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>
                    <small class="form-text text-muted">
                        Tekan Enter untuk menambah diagnosis
                    </small>
                </div>

                <div class="mt-3">
                    <strong class="fw-bold mb-2 d-block">Daftar Penyakit Keluarga</strong>
                    <div class="bg-light p-3 border rounded family-disease-container">
                        <div id="family-disease-list-modal" class="family-disease-list-sortable">
                            <!-- Diagnosis list will be dynamically populated here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btn-save-family-disease" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Specific Diagnosis -->
<div class="modal fade" id="modal-edit-family-disease" tabindex="-1" aria-labelledby="editFamilyDiseaseLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editFamilyDiseaseLabel">Edit Penyakit Keluarga</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="edit-family-disease-input" class="form-label fw-bold">Nama Penyakit</label>
                    <input type="text" class="form-control" id="edit-family-disease-input">
                    <input type="hidden" id="edit-family-disease-index">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn-update-family-disease" class="btn btn-primary">Perbarui</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function () {
            function safeParseJson(value, defaultValue = []) {
                if (Array.isArray(value)) return value;

                if (typeof value === 'string') {
                    try {
                        const parsed = JSON.parse(value);
                        return Array.isArray(parsed) ? parsed : defaultValue;
                    } catch (error) {
                        console.error('Error parsing family diagnosis JSON:', error);
                        return defaultValue;
                    }
                }

                return defaultValue;
            }

            let familyDiseaseList = safeParseJson(
                @json($asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi[0]['riwayat_kesehatan_penyakit_keluarga'] ?? [])
            );

            function removeDuplicates(arr) {
                return Array.from(new Set(arr.filter(item => item && item.trim() !== '')));
            }

            // Function to render diagnosis list
            function renderFamilyDiseaseList() {
                familyDiseaseList = removeDuplicates(familyDiseaseList);

                const modalList = $('#family-disease-list-modal');
                const displayList = $('.family-disease-display-list');
                modalList.empty();
                displayList.empty();

                familyDiseaseList.forEach((disease, index) => {
                    // For modal list
                    const modalItem = $(`
                        <div class="d-flex justify-content-between align-items-center mb-2 family-disease-item" data-index="${index}">
                            <div class="d-flex align-items-center">
                                <span class="family-disease-drag-handle me-2" style="cursor: move;">
                                    <i class="bi bi-grip-vertical"></i>
                                </span>
                                <span class="family-disease-text">${disease}</span>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary me-2 btn-edit-family-disease" data-index="${index}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger btn-remove-family-disease" data-index="${index}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    `);
                    modalList.append(modalItem);

                    // For main display list
                    const displayItem = $(`
                        <div class="family-disease-display-item mb-2 d-flex justify-content-between align-items-center" data-disease="${disease}">
                            <div class="d-flex align-items-center w-100">
                                <span class="family-disease-drag-handle me-2" style="cursor: move;">
                                    <i class="bi bi-grip-vertical"></i>
                                </span>
                                <span class="flex-grow-1">${disease}</span>
                            </div>
                        </div>
                    `);
                    displayList.append(displayItem);
                });

                $('#family-disease-data-input').val(JSON.stringify(familyDiseaseList));

                initializeFamilyDiseaseSortable();
            }

            // Initialize Sortable for drag and drop
            function initializeFamilyDiseaseSortable() {
                // Destroy existing Sortable instances if they exist
                if (window.familyDiseaseSortableModal) {
                    window.familyDiseaseSortableModal.destroy();
                }
                if (window.familyDiseaseSortableDisplay) {
                    window.familyDiseaseSortableDisplay.destroy();
                }

                // Sortable for modal list
                const modalList = document.getElementById('family-disease-list-modal');
                if (modalList && window.Sortable) {
                    window.familyDiseaseSortableModal = new Sortable(modalList, {
                        animation: 150,
                        handle: '.family-disease-drag-handle',
                        onEnd: function (evt) {
                            const newOrder = [];
                            $('#family-disease-list-modal .family-disease-item').each(function () {
                                const disease = $(this).find('.family-disease-text').text();
                                if (disease && !newOrder.includes(disease)) {
                                    newOrder.push(disease);
                                }
                            });

                            familyDiseaseList = newOrder;
                            renderFamilyDiseaseList();
                        }
                    });
                }

                // Sortable for display list
                const displayList = document.querySelector('.family-disease-display-list');
                if (displayList && window.Sortable) {
                    window.familyDiseaseSortableDisplay = new Sortable(displayList, {
                        animation: 150,
                        handle: '.family-disease-drag-handle',
                        onEnd: function (evt) {
                            // Reorder diagnoses in display list
                            const newOrder = [];
                            $('.family-disease-display-list .family-disease-display-item').each(function () {
                                const disease = $(this).data('disease');
                                if (disease && !newOrder.includes(disease)) {
                                    newOrder.push(disease);
                                }
                            });

                            // Update diagnoses
                            familyDiseaseList = newOrder;
                            renderFamilyDiseaseList();
                        }
                    });
                }
            }

            // Open modal to add/edit diagnoses
            $('#btn-open-family-disease-modal').on('click', function () {
                renderFamilyDiseaseList();
                $('#modal-family-disease-history').modal('show');
            });

            $('#btn-add-family-disease').on('click', function () {
                const newDisease = $('#family-disease-input').val().trim();
                if (newDisease) {
                    if (!familyDiseaseList.some(d => d.toLowerCase() === newDisease.toLowerCase())) {
                        familyDiseaseList.push(newDisease);
                        renderFamilyDiseaseList();
                        $('#family-disease-input').val('');
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Penyakit keluarga sudah ada dalam daftar',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            });

            // Handle Enter key for adding diagnosis
            $('#family-disease-input').on('keypress', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#btn-add-family-disease').click();
                }
            });

            // Open edit diagnosis modal
            $(document).on('click', '.btn-edit-family-disease', function () {
                const index = $(this).data('index');
                const disease = familyDiseaseList[index];

                $('#edit-family-disease-input').val(disease);
                $('#edit-family-disease-index').val(index);
                $('#modal-edit-family-disease').modal('show');
            });

            // Update diagnosis
            $('#btn-update-family-disease').on('click', function () {
                const index = $('#edit-family-disease-index').val();
                const updatedDisease = $('#edit-family-disease-input').val().trim();

                if (updatedDisease) {
                    const duplicateIndex = familyDiseaseList.findIndex(
                        (d, i) => d.toLowerCase() === updatedDisease.toLowerCase() && i !== parseInt(index)
                    );

                    if (duplicateIndex === -1) {
                        familyDiseaseList[index] = updatedDisease;
                        renderFamilyDiseaseList();
                        $('#modal-edit-family-disease').modal('hide');
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Penyakit keluarga sudah ada dalam daftar',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            });

            // Remove diagnosis
            $(document).on('click', '.btn-remove-family-disease', function () {
                const index = $(this).data('index');
                familyDiseaseList.splice(index, 1);
                renderFamilyDiseaseList();
            });

            // Save diagnoses
            $('#btn-save-family-disease').on('click', function () {
                familyDiseaseList = removeDuplicates(familyDiseaseList);
                renderFamilyDiseaseList();
                $('#modal-family-disease-history').modal('hide');
            });

            renderFamilyDiseaseList();
        });
    </script>
@endpush
