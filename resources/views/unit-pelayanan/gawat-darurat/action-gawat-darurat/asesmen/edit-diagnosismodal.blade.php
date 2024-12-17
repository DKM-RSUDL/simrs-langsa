<!-- Button untuk membuka modal edit diagnosis -->
<button type="button" class="btn btn-sm" id="openEditDiagnosisModal">
    <i class="bi bi-plus-square"></i> Tambah
</button>

<!-- Modal Edit Diagnosis -->
<div class="modal fade" id="editDiagnosisModal" tabindex="-1" aria-labelledby="editDiagnosisModalLabel" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDiagnosisModalLabel">Edit Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDiagnosisForm">
                    <h6 class="fw-bold">Tambah Diagnosis</h6>
                    <p class="text-muted">(Isi diagnosis pada kolom dibawah dan Tekan tambah untuk menambah ke daftar
                        diagnosis)</p>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="editDiagnosisInput" placeholder="Nama Diagnosis"
                            autocomplete="off">
                    </div>
                    <button type="button" id="btnEditListDiagnosis" class="btn btn-sm btn-primary mt-2">Tambah</button>
                </form>

                <h6 class="fw-bold mt-5">Daftar Diagnosis</h6>
                <ul id="editListDiagnosis" class="list-unstyled"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveEditDiagnosis" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Deklarasikan variabel untuk modal dan data di scope yang bisa diakses
    document.addEventListener('DOMContentLoaded', function() {
        const editDiagnosisModal = new bootstrap.Modal(document.getElementById('editDiagnosisModal'));
        let editDiagnoses = [];

        function displayEditDiagnosis() {
            const modalList = document.getElementById('editListDiagnosis');
            const mainList = document.getElementById('editDiagnoseList');

            // Update modal list
            modalList.innerHTML = editDiagnoses.length ? editDiagnoses.map((diagnosis, index) => `
            <li class="d-flex justify-content-between align-items-center mb-2">
                <span>${diagnosis}</span>
                <button class="btn btn-sm btn-link delete-modal-diagnosis p-0" data-index="${index}">
                    <i class="bi bi-trash-fill text-danger"></i>
                </button>
            </li>
        `).join('') : '<li class="text-muted">Tidak ada diagnosis</li>';

            // Update main list dengan drag handle
            mainList.innerHTML = editDiagnoses.length ? `
            <div class="diagnosis-list">
                ${editDiagnoses.map((diagnosis, index) => `
                    <div class="diagnosis-item mb-2" data-diagnosis="${diagnosis}">
                        <div class="d-flex align-items-center">
                            <span class="drag-handle me-2" style="cursor: move;">
                                <i class="bi bi-grip-vertical"></i>
                            </span>
                            <div class="me-2">
                                <span class="badge bg-primary">${index + 1}</span>
                            </div>
                            <div class="flex-grow-1">
                                ${diagnosis}
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>
        ` : '<em>Tidak ada diagnosis</em>';

            // Initialize Sortable jika ada items
            if (editDiagnoses.length) {
                const diagnosisList = mainList.querySelector('.diagnosis-list');
                if (diagnosisList) {
                    new Sortable(diagnosisList, {
                        animation: 150,
                        handle: '.drag-handle',
                        onEnd: function(evt) {
                            // Mengambil urutan baru berdasarkan data-diagnosis
                            const items = diagnosisList.querySelectorAll('.diagnosis-item');
                            const newOrder = Array.from(items).map(item => item.dataset.diagnosis);

                            // Update array dengan urutan baru
                            editDiagnoses = newOrder;

                            // Update tampilan untuk memastikan konsistensi
                            displayEditDiagnosis();

                            // Update data original
                            window.originalDiagnosisData = [...editDiagnoses];
                        }
                    });
                }
            }
        }

        document.getElementById('openEditDiagnosisModal').addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();

            document.getElementById('editDiagnosisInput').value = '';
            editDiagnoses = Array.isArray(window.originalDiagnosisData) ? [...window
                .originalDiagnosisData
            ] : [];

            displayEditDiagnosis();
            editDiagnosisModal.show();
        });

        document.getElementById('btnEditListDiagnosis').addEventListener('click', function(e) {
            e.preventDefault();
            const input = document.getElementById('editDiagnosisInput');
            const diagnosis = input.value.trim();

            if (!diagnosis) {
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Harap isi diagnosis',
                    icon: 'warning'
                });
                return;
            }

            editDiagnoses.push(diagnosis);
            input.value = '';
            displayEditDiagnosis();
        });

        document.getElementById('btnSaveEditDiagnosis').addEventListener('click', function(e) {
            e.preventDefault();
            window.originalDiagnosisData = [...editDiagnoses];
            displayEditDiagnosis();
            editDiagnosisModal.hide();
        });

        document.getElementById('editListDiagnosis').addEventListener('click', function(e) {
            const deleteBtn = e.target.closest('.delete-modal-diagnosis');
            if (deleteBtn) {
                e.preventDefault();
                const index = parseInt(deleteBtn.dataset.index);
                editDiagnoses.splice(index, 1);
                displayEditDiagnosis();
            }
        });

        document.getElementById('editDiagnosisModal').addEventListener('hidden.bs.modal', function(event) {
            event.stopPropagation();
            document.getElementById('editDiagnosisInput').value = '';
        });
    });

    // document.addEventListener('DOMContentLoaded', function() {
    //     // Inisialisasi modal
    //     editDiagnosisModal = new bootstrap.Modal(document.getElementById('editDiagnosisModal'));

    //     // Fungsi untuk mengupdate tampilan list di modal
    //     function updateEditModalView() {
    //         const editListDiagnosis = document.getElementById('editListDiagnosis');
    //         if (!editListDiagnosis) return;

    //         if (editDiagnoses.length === 0) {
    //             editListDiagnosis.innerHTML = '<li class="text-muted">Tidak ada diagnosis</li>';
    //             return;
    //         }

    //         editListDiagnosis.innerHTML = editDiagnoses.map((diagnosis, index) => `
    //         <li class="d-flex justify-content-between align-items-center mb-2">
    //             <span>${diagnosis}</span>
    //             <button class="btn btn-sm btn-link delete-modal-diagnosis p-0" data-index="${index}">
    //                 <i class="bi bi-trash-fill text-danger"></i>
    //             </button>
    //         </li>
    //     `).join('');
    //     }

    //     // Fungsi untuk mengupdate tampilan di main form
    //     function updateEditTableView() {
    //         const diagnosisHtml = editDiagnoses.map((diagnosis, index) => `
    //         <div class="diagnosis-item mb-2">
    //             <div class="d-flex align-items-center">
    //                 <div class="me-2">
    //                     <span class="badge bg-primary">${index + 1}</span>
    //                 </div>
    //                 <div class="flex-grow-1">
    //                     ${diagnosis}
    //                 </div>
    //             </div>
    //         </div>
    //     `).join('');

    //         $('#editDiagnoseList').html(diagnosisHtml || '<em>Tidak ada diagnosis</em>');
    //     }

    //     // Handler untuk membuka modal
    //     $(document).on('click', '#openEditDiagnosisModal', function(event) {
    //         event.preventDefault();
    //         event.stopPropagation();
    //         console.log('Opening modal with data:', window.originalDiagnosisData);

    //         // Reset form dan data
    //         $('#editDiagnosisInput').val('');
    //         editDiagnoses = Array.isArray(window.originalDiagnosisData) ? [...window
    //             .originalDiagnosisData
    //         ] : [];

    //         updateEditModalView();
    //         editDiagnosisModal.show();
    //     });

    //     // Handler untuk menambah diagnosis
    //     $(document).on('click', '#btnEditListDiagnosis', function(e) {
    //         e.preventDefault();

    //         const diagnosisInput = $('#editDiagnosisInput').val().trim();

    //         if (!diagnosisInput) {
    //             Swal.fire({
    //                 title: 'Peringatan',
    //                 text: 'Harap isi diagnosis',
    //                 icon: 'warning'
    //             });
    //             return;
    //         }

    //         editDiagnoses.push(diagnosisInput);
    //         $('#editDiagnosisInput').val('');
    //         updateEditModalView();
    //     });

    //     // Handler untuk menyimpan perubahan
    //     $(document).on('click', '#btnSaveEditDiagnosis', function(e) {
    //         e.preventDefault();
    //         console.log('Saving diagnoses:', editDiagnoses);

    //         window.originalDiagnosisData = [...editDiagnoses];
    //         updateEditTableView();
    //         editDiagnosisModal.hide();
    //     });

    //     // Handler untuk menghapus diagnosis
    //     $(document).on('click', '.delete-modal-diagnosis', function(e) {
    //         e.preventDefault();
    //         e.stopPropagation();
    //         const index = $(this).data('index');
    //         editDiagnoses.splice(index, 1);
    //         updateEditModalView();
    //     });

    //     // Prevent modal from closing parent
    //     $('#editDiagnosisModal').on('hidden.bs.modal', function(event) {
    //         event.stopPropagation();
    //         $('#editDiagnosisInput').val('');
    //     });
    // });


    // CSS untuk styling
</script>

<style>
    #editListDiagnosis li {
        padding: 8px;
        border-bottom: 1px solid #eee;
    }

    #editListDiagnosis li:last-child {
        border-bottom: none;
    }

    .delete-modal-diagnosis {
        color: #dc3545;
        background: none;
        border: none;
        padding: 0;
    }

    .delete-modal-diagnosis:hover {
        color: #c82333;
    }

    .diagnosis-item {
        background-color: #f8f9fa;
        border-radius: 4px;
        padding: 8px;
    }

    .diagnosis-item .badge {
        min-width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .drag-handle {
        cursor: move;
        padding: 0 8px;
        color: #666;
    }

    .drag-handle:hover {
        color: #333;
    }

    .diagnosis-item {
        background-color: #f8f9fa;
        border-radius: 4px;
        padding: 8px;
    }
</style>
