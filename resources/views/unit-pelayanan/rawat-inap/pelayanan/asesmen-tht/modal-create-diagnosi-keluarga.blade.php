<!-- Modal for Family Disease History Input -->
<div class="modal fade" id="modal-create-diagnosis-keluarga" tabindex="-1" aria-labelledby="verticalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="verticalCenterLabel">Input Riwayat Penyakit Keluarga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong class="fw-bold">Tambah Penyakit Keluarga</strong>
                <p>
                    (Isi diagnosis pada kolom dibawah dan <span class="fw-bold">Tekan Enter</span> untuk menambah ke
                    daftar diagnosis. Satu baris untuk satu diagnosis)
                </p>
                <div class="dropdown">
                    <input type="text" class="form-control" id="searchDiagnosisInputKeluarga" placeholder="Nama Diagnosis Keluarga">
                </div>
                <div class="mt-2 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary mt-2" id="btnAddDiagnosisKeluarga">Tambah</button>
                </div>

                <div class="mt-3">
                    <strong class="fw-bold">Daftar Penyakit Keluarga</strong>
                    <div class="bg-light p-3 border rounded">
                        <ol type="1" id="diagnosisListKeluarga">
                            <!-- List of Family Diagnoses -->
                        </ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveDiagnosisKeluarga" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.modal-daftar-input-diagnosis-keluarga')

<script>
    $('#btn-diagnosis-keluarga').on('click', function() {
        $('#modal-create-diagnosis-keluarga').modal('show');
    });

    let dataDiagnosisKeluarga = @json($dataResume->diagnosis_keluarga ?? []);

    $(document).ready(function() {
        // Function to display family diagnoses
        function displayDiagnosisKeluarga() {
            let diagnosisListKeluarga = '';
            let diagnoseDisplayKeluarga = '';

            if (dataDiagnosisKeluarga && Array.isArray(dataDiagnosisKeluarga)) {
                dataDiagnosisKeluarga.forEach((diagnosis, index) => {
                    let uniqueId = 'diagnosis-keluarga-' + index;

                    // For modal diagnosis
                    diagnosisListKeluarga += `
                        <li class="list-group-item d-flex justify-content-between align-items-center" id="${uniqueId}">
                            <a href="javascript:void(0)" class="fw-bold edit-diagnosis-keluarga" data-id="${uniqueId}">${diagnosis}</a>
                            <button type="button" class="btn remove-diagnosis-keluarga mt-1" data-id="${uniqueId}">
                                <i class="fas fa-times text-danger"></i>
                            </button>
                        </li>`;

                    // For main display with drag handle
                    diagnoseDisplayKeluarga += `
                        <div class="diagnosis-item-keluarga d-flex justify-content-between align-items-center mb-2"
                             id="main-${uniqueId}" data-diagnosis="${diagnosis}">
                            <div class="d-flex align-items-center gap-2">
                                <span class="drag-handle" style="cursor: move;">
                                    <i class="bi bi-grip-vertical"></i>
                                </span>
                                <a href="javascript:void(0)" class="fw-bold">${diagnosis}</a>
                            </div>
                            <button type="button" class="btn remove-main-diagnosis-keluarga" data-id="${uniqueId}">
                                <i class="fas fa-times text-danger"></i>
                            </button>
                        </div>`;
                });
            }

            $('#diagnosisListKeluarga').html(diagnosisListKeluarga);
            $('.diagnosis-list-keluarga').html(diagnoseDisplayKeluarga);

            // Initialize Sortable
            initializeSortableKeluarga();
        }

        function initializeSortableKeluarga() {
            let diagnosisListKeluarga = document.querySelector('.diagnosis-list-keluarga');
            if (diagnosisListKeluarga) {
                new Sortable(diagnosisListKeluarga, {
                    animation: 150,
                    handle: '.drag-handle',
                    onEnd: function() {
                        // Update dataDiagnosisKeluarga array after drag
                        dataDiagnosisKeluarga = [];
                        $('.diagnosis-item-keluarga').each(function() {
                            let diagnosis = $(this).data('diagnosis');
                            dataDiagnosisKeluarga.push(diagnosis);
                        });
                        console.log('Urutan diagnosis keluarga setelah drag:', dataDiagnosisKeluarga);
                    }
                });
            }
        }

        // Call function when document is ready
        displayDiagnosisKeluarga();

        // Display diagnoses when modal is opened
        $('#btn-diagnosis-keluarga').on('click', function() {
            displayDiagnosisKeluarga();
            $('#modal-create-diagnosis-keluarga').modal('show');
        });

        // Add diagnosis to modal
        $('#btnAddDiagnosisKeluarga').click(function() {
            var diagnosis = $('#searchDiagnosisInputKeluarga').val();

            if (diagnosis !== '') {
                dataDiagnosisKeluarga.push(diagnosis);
                displayDiagnosisKeluarga();
                $('#searchDiagnosisInputKeluarga').val('');
            }
        });

        // Enter key on diagnosis input
        $('#searchDiagnosisInputKeluarga').keypress(function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btnAddDiagnosisKeluarga').click();
            }
        });

        // Open edit modal
        $(document).on('click', '.edit-diagnosis-keluarga', function() {
            var diagnosisId = $(this).data('id');
            var index = diagnosisId.split('-')[2]; // Updated to account for new ID format
            var diagnosisText = dataDiagnosisKeluarga[index];

            $('#editDiagnosisTextareaKeluarga').val(diagnosisText);
            $('#editDiagnosisIdKeluarga').val(index);

            $('#modal-daftar-input-diagnosis-keluarga').modal('show');
        });

        // Save edit diagnosis
        $('#btnUpdateDiagnosisKeluarga').click(function() {
            var updatedDiagnosis = $('#editDiagnosisTextareaKeluarga').val();
            var index = $('#editDiagnosisIdKeluarga').val();

            dataDiagnosisKeluarga[index] = updatedDiagnosis;
            displayDiagnosisKeluarga();

            $('#modal-daftar-input-diagnosis-keluarga').modal('hide');
        });

        // Remove diagnosis
        $(document).on('click', '.remove-diagnosis-keluarga, .remove-main-diagnosis-keluarga', function() {
            var diagnosisId = $(this).data('id');
            var index = diagnosisId.split('-')[2]; // Updated to account for new ID format

            dataDiagnosisKeluarga.splice(index, 1);
            displayDiagnosisKeluarga();
        });

        // Save diagnosis
        $('#btnSaveDiagnosisKeluarga').click(function() {
            displayDiagnosisKeluarga();
            $('#modal-create-diagnosis-keluarga').modal('hide');
        });
    });
</script>
