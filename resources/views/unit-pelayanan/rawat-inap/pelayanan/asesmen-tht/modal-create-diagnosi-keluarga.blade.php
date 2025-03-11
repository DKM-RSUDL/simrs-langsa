<!-- Modal for Family Disease History Input -->
<div class="modal fade" id="modal-create-diagnosis-keluarga" tabindex="-1" aria-labelledby="verticalCenterLabel"
    aria-hidden="true">
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
                    <input type="text" class="form-control" id="searchDiagnosisInputKeluarga"
                        placeholder="Nama Diagnosis Keluarga">
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

    $(document).ready(function() {
        // Inisialisasi data dari database
        let dataDiagnosisKeluarga = @json($dataResume->riwayat_kesehatan_penyakit_keluarga ?? []);

        // Fungsi untuk menghapus duplikat
        function removeDuplicates(arr) {
            return [...new Set(arr)];
        }

        // Fungsi untuk memperbarui tampilan
        function displayDiagnosisKeluarga() {
            // Bersihkan duplikat
            dataDiagnosisKeluarga = removeDuplicates(dataDiagnosisKeluarga);

            let diagnosisListKeluarga = '';
            let diagnoseDisplayKeluarga = '';

            if (dataDiagnosisKeluarga && Array.isArray(dataDiagnosisKeluarga)) {
                dataDiagnosisKeluarga.forEach((diagnosis, index) => {
                    let uniqueId = 'diagnosis-keluarga-' + index;

                    // Untuk modal
                    diagnosisListKeluarga += `
                    <li class="list-group-item d-flex justify-content-between align-items-center" id="${uniqueId}">
                        <span class="fw-bold">${diagnosis}</span>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-link edit-diagnosis-keluarga" data-id="${uniqueId}">
                                <i class="bi bi-pencil text-primary"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-link remove-diagnosis-keluarga" data-id="${uniqueId}">
                                <i class="bi bi-trash text-danger"></i>
                            </button>
                        </div>
                    </li>`;

                    // Untuk tampilan utama
                    diagnoseDisplayKeluarga += `
                    <div class="diagnosis-item-keluarga d-flex justify-content-between align-items-center mb-2"
                         id="main-${uniqueId}" data-diagnosis="${diagnosis}">
                        <div class="d-flex align-items-center gap-2">
                            <span class="drag-handle" style="cursor: move;">
                                <i class="bi bi-grip-vertical"></i>
                            </span>
                            <span class="fw-bold">${diagnosis}</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-link remove-main-diagnosis-keluarga" data-id="${uniqueId}">
                            <i class="bi bi-x-circle text-danger"></i>
                        </button>
                    </div>`;
                });
            }

            $('#diagnosisListKeluarga').html(diagnosisListKeluarga);
            $('.diagnosis-list-keluarga').html(diagnoseDisplayKeluarga);

            // Update hidden input
            $('#diagnosisKeluargaData').val(JSON.stringify(dataDiagnosisKeluarga));

            initializeSortableKeluarga();
        }

        function initializeSortableKeluarga() {
            let diagnosisListKeluarga = document.querySelector('.diagnosis-list-keluarga');
            if (diagnosisListKeluarga) {
                new Sortable(diagnosisListKeluarga, {
                    animation: 150,
                    handle: '.drag-handle',
                    onEnd: function() {
                        // Buat array baru dari urutan setelah drag
                        let newOrder = [];
                        $('.diagnosis-item-keluarga').each(function() {
                            let diagnosis = $(this).data('diagnosis');
                            if (diagnosis && !newOrder.includes(diagnosis)) {
                                newOrder.push(diagnosis);
                            }
                        });

                        // Update array tanpa duplikat
                        dataDiagnosisKeluarga = newOrder;

                        // Update hidden input dan tampilan
                        $('#diagnosisKeluargaData').val(JSON.stringify(dataDiagnosisKeluarga));
                        displayDiagnosisKeluarga();
                    }
                });
            }
        }

        // Tampilkan diagnosis saat modal dibuka
        $('#btn-diagnosis-keluarga').on('click', function() {
            displayDiagnosisKeluarga();
            $('#modal-create-diagnosis-keluarga').modal('show');
        });

        // Tambah diagnosis
        $('#btnAddDiagnosisKeluarga').click(function() {
            var diagnosis = $('#searchDiagnosisInputKeluarga').val().trim();
            if (diagnosis !== '') {
                if (!dataDiagnosisKeluarga.includes(diagnosis)) {
                    dataDiagnosisKeluarga.push(diagnosis);
                    displayDiagnosisKeluarga();
                    $('#searchDiagnosisInputKeluarga').val('');
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Diagnosis ini sudah ada dalam daftar'
                    });
                }
            }
        });

        // Handle enter key
        $('#searchDiagnosisInputKeluarga').keypress(function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btnAddDiagnosisKeluarga').click();
            }
        });

        // Open edit modal
        $(document).on('click', '.edit-diagnosis-keluarga', function() {
            var diagnosisId = $(this).data('id');
            var index = diagnosisId.split('-')[2];
            var diagnosisText = dataDiagnosisKeluarga[index];

            $('#editDiagnosisTextareaKeluarga').val(diagnosisText);
            $('#editDiagnosisIdKeluarga').val(index);

            $('#modal-daftar-input-diagnosis-keluarga').modal('show');
        });

        // Update diagnosis
        $('#btnUpdateDiagnosisKeluarga').click(function() {
            var index = parseInt($('#editDiagnosisIdKeluarga').val());
            var updatedDiagnosis = $('#editDiagnosisTextareaKeluarga').val().trim();

            if (updatedDiagnosis !== '') {
                dataDiagnosisKeluarga[index] = updatedDiagnosis;
                displayDiagnosisKeluarga();
                $('#modal-daftar-input-diagnosis-keluarga').modal('hide');
            }
        });

        // Remove diagnosis
        $(document).on('click', '.remove-diagnosis-keluarga, .remove-main-diagnosis-keluarga', function() {
            var diagnosisId = $(this).data('id');
            var index = diagnosisId.split('-')[2];
            if (index >= 0 && index < dataDiagnosisKeluarga.length) {
                dataDiagnosisKeluarga.splice(index, 1);
                displayDiagnosisKeluarga();
            }
        });

        // Save diagnosis
        $('#btnSaveDiagnosisKeluarga').click(function() {
            dataDiagnosisKeluarga = removeDuplicates(dataDiagnosisKeluarga);
            displayDiagnosisKeluarga();
            $('#modal-create-diagnosis-keluarga').modal('hide');
        });

        // Inisialisasi tampilan awal
        displayDiagnosisKeluarga();
    });
</script>
