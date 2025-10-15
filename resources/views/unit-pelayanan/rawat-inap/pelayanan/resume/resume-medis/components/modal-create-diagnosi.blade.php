<div class="modal fade" id="modal-create-diagnosis" tabindex="-1" aria-labelledby="verticalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="verticalCenterLabel">Input Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong class="fw-bold">Tambah Diagnosis</strong>
                <p>
                    (Isi diagnosis pada kolom dibawah dan <span class="fw-bold">Tekan Enter</span> untuk menambah ke
                    daftar diagnosis. Satu baris untuk satu diagnosis )
                </p>
                <div class="dropdown">
                    <input type="text" class="form-control" id="searchDiagnosisInput" placeholder="Nama Diagnosis">
                </div>
                <div class="mt-2 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary mt-2" id="btnAddDiagnosis">Tambah</button>
                </div>

                <div class="mt-3">
                    <strong class="fw-bold">Daftar Diagnosis</strong>
                    <div class="bg-light p-3 border rounded">
                        <ol type="1" id="diagnosisList">
                            <!-- List of Diagnoses -->
                        </ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveDiagnose" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-daftar-input-diagnosis')

@push('js')
    <script>
        $(document).ready(function() {
            $('#btn-diagnosis').on('click', function() {
                $('#modal-create-diagnosis').modal('show');
            });
        });

        // kode baru :
        let dataDiagnosis = @json($dataResume->diagnosis ?? []);

        $(document).ready(function() {
            // Fungsi untuk menampilkan diagnosis
            function displayDiagnosis() {
                let diagnosisList = '';
                let diagnoseDisplay = '';

                if (dataDiagnosis && Array.isArray(dataDiagnosis)) {
                    dataDiagnosis.forEach((diagnosis, index) => {
                        let uniqueId = 'diagnosis-' + index;

                        // Untuk modal diagnosis
                        diagnosisList += `
                <li class="list-group-item d-flex justify-content-between align-items-center" id="${uniqueId}">
                    <a href="javascript:void(0)" class="fw-bold edit-diagnosis" data-id="${uniqueId}">${diagnosis}</a>
                    <button type="button" class="btn remove-diagnosis mt-1" data-id="${uniqueId}">
                        <i class="fas fa-times text-danger"></i>
                    </button>
                </li>`;

                        // Untuk tampilan utama dengan handle untuk drag
                        diagnoseDisplay += `
                <div class="diagnosis-item d-flex justify-content-between align-items-center mb-2"
                    id="main-${uniqueId}" data-diagnosis="${diagnosis}">
                    <div class="d-flex align-items-center gap-2">
                        <span class="drag-handle" style="cursor: move;">
                            <i class="bi bi-grip-vertical"></i>
                        </span>
                        <a href="javascript:void(0)" class="fw-bold">${diagnosis}</a>
                    </div>
                    <button type="button" class="btn remove-main-diagnosis" data-id="${uniqueId}">
                        <i class="fas fa-times text-danger"></i>
                    </button>
                </div>`;
                    });
                }

                $('#diagnosisList').html(diagnosisList);
                $('.diagnosis-list').html(diagnoseDisplay);

                // Initialize Sortable
                initializeSortable();
            }

            function initializeSortable() {
                let diagnosisList = document.querySelector('.diagnosis-list');
                if (diagnosisList) {
                    new Sortable(diagnosisList, {
                        animation: 150,
                        handle: '.drag-handle',
                        onEnd: function() {
                            // Update dataDiagnosis array setelah drag
                            dataDiagnosis = [];
                            $('.diagnosis-item').each(function() {
                                let diagnosis = $(this).data('diagnosis');
                                dataDiagnosis.push(diagnosis);
                            });
                            // console.log('Urutan diagnosis setelah drag:', dataDiagnosis);
                        }
                    });
                }
            }

            // Panggil fungsi saat dokumen siap
            displayDiagnosis();

            // Tampilkan diagnosis saat modal dibuka
            $('#btn-diagnosis').on('click', function() {
                displayDiagnosis();
                $('#modal-create-diagnosis').modal('show');
            });

            // Add diagnosis ke modal
            $('#btnAddDiagnosis').click(function() {
                var diagnosis = $('#searchDiagnosisInput').val();

                if (diagnosis !== '') {
                    dataDiagnosis.push(diagnosis);
                    displayDiagnosis();
                    $('#searchDiagnosisInput').val('');
                }
            });

            // Enter key pada input diagnosis
            $('#searchDiagnosisInput').keypress(function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#btnAddDiagnosis').click();
                }
            });

            // Open edit modal
            $(document).on('click', '.edit-diagnosis', function() {
                var diagnosisId = $(this).data('id');
                var index = diagnosisId.split('-')[1];
                var diagnosisText = dataDiagnosis[index];

                $('#editDiagnosisTextarea').val(diagnosisText);
                $('#editDiagnosisId').val(index);

                $('#modal-daftar-input-diagnosis').modal('show');
            });

            // Save edit diagnosis
            $('#btnUpdateDiagnosis').click(function() {
                var updatedDiagnosis = $('#editDiagnosisTextarea').val();
                var index = $('#editDiagnosisId').val();

                dataDiagnosis[index] = updatedDiagnosis;
                displayDiagnosis();

                $('#modal-daftar-input-diagnosis').modal('hide');
            });

            // Remove diagnosis
            $(document).on('click', '.remove-diagnosis, .remove-main-diagnosis', function() {
                var diagnosisId = $(this).data('id');
                var index = diagnosisId.split('-')[1];

                dataDiagnosis.splice(index, 1);
                displayDiagnosis();
            });

            // Save diagnosis
            $('#btnSaveDiagnose').click(function() {
                displayDiagnosis();
                $('#modal-create-diagnosis').modal('hide');
            });
        });

        // kode lama
        // let dataDiagnosis = @json($dataResume->diagnosis ?? []);
        // // console.log(dataDiagnosis);

        // $(document).ready(function() {
        //     // Fungsi untuk menampilkan diagnosis
        //     function displayDiagnosis() {
        //         let diagnosisList = '';
        //         let diagnoseDisplay = '';

        //         if (dataDiagnosis && Array.isArray(dataDiagnosis)) {
        //             dataDiagnosis.forEach((diagnosis, index) => {
        //                 let uniqueId = 'diagnosis-' + index;

        //                 // Untuk modal diagnosis
        //                 diagnosisList += `
        //                 <li class="list-group-item d-flex justify-content-between align-items-center" id="${uniqueId}">
        //                     <a href="javascript:void(0)" class="fw-bold edit-diagnosis" data-id="${uniqueId}">${diagnosis}</a>
        //                     <button type="button" class="btn remove-diagnosis" data-id="${uniqueId}"><i class="fas fa-times text-danger"></i></button>
        //                 </li>
        //             `;

        //                 // Untuk tampilan utama
        //                 diagnoseDisplay += `
        //                 <div class="d-flex justify-content-between align-items-center" id="main-${uniqueId}">
        //                     <a href="javascript:void(0)" class="fw-bold">${diagnosis}</a>
        //                     <button type="button" class="btn remove-main-diagnosis" data-id="${uniqueId}"><i class="fas fa-times text-danger"></i></button>
        //                 </div><br>
        //             `;
        //             });
        //         }

        //         $('#diagnosisList').html(diagnosisList);
        //         $('#diagnoseDisplay').html(diagnoseDisplay);
        //     }

        //     // Panggil fungsi saat dokumen siap
        //     displayDiagnosis();

        //     // Tampilkan diagnosis saat modal dibuka
        //     $('#btn-diagnosis').on('click', function() {
        //         displayDiagnosis();
        //         $('#modal-create-diagnosis').modal('show');
        //     });

        //     // Add diagnosis ke modal
        //     $('#btnAddDiagnosis').click(function() {
        //         var diagnosis = $('#searchDiagnosisInput').val();

        //         if (diagnosis !== '') {
        //             dataDiagnosis.push(diagnosis);
        //             displayDiagnosis();
        //             $('#searchDiagnosisInput').val('');
        //         }
        //     });

        //     // Open edit modal
        //     $(document).on('click', '.edit-diagnosis', function() {
        //         var diagnosisId = $(this).data('id');
        //         var index = diagnosisId.split('-')[1];
        //         var diagnosisText = dataDiagnosis[index];

        //         $('#editDiagnosisTextarea').val(diagnosisText);
        //         $('#editDiagnosisId').val(index);

        //         $('#modal-daftar-input-diagnosis').modal('show');
        //     });

        //     // Save edit diagnosis
        //     $('#btnUpdateDiagnosis').click(function() {
        //         var updatedDiagnosis = $('#editDiagnosisTextarea').val();
        //         var index = $('#editDiagnosisId').val();

        //         dataDiagnosis[index] = updatedDiagnosis;
        //         displayDiagnosis();

        //         $('#modal-daftar-input-diagnosis').modal('hide');
        //     });

        //     // Remove diagnosis
        //     $(document).on('click', '.remove-diagnosis, .remove-main-diagnosis', function() {
        //         var diagnosisId = $(this).data('id');
        //         var index = diagnosisId.split('-')[1];

        //         dataDiagnosis.splice(index, 1);
        //         displayDiagnosis();
        //     });

        //     // Save diagnosis
        //     $('#btnSaveDiagnose').click(function() {
        //         displayDiagnosis();
        //         $('#modal-create-diagnosis').modal('hide');

        //         // Di sini Anda bisa menambahkan kode untuk mengirim dataDiagnosis ke server
        //         // misalnya dengan Ajax request
        //     });
        // });
    </script>
@endpush
