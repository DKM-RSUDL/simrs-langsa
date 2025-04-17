<div class="modal fade" id="modal-create-diagnosis" tabindex="-1" aria-labelledby="verticalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="verticalCenterLabel">Input Riwayat Penyakit Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong class="fw-bold">Tambah Penyakit</strong>
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
                    <strong class="fw-bold">Daftar Penyakit</strong>
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
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.modal-daftar-input-diagnosis')

@push('js')
    <script>
        $('#btn-diagnosis').on('click', function() {
            $('#modal-create-diagnosis').modal('show');
        });

        $(document).ready(function() {
            // Inisialisasi data dari database jika ada
            let dataDiagnosis = @json($dataResume->riwayat_kesehatan_penyakit_diderita ?? []);

            // Fungsi untuk menghapus duplikat dari array
            function removeDuplicates(arr) {
                return [...new Set(arr)];
            }

            // Fungsi untuk memperbarui hidden input dan tampilan
            function displayDiagnosis() {
                // Bersihkan duplikat sebelum menampilkan
                dataDiagnosis = removeDuplicates(dataDiagnosis);

                let diagnosisList = '';
                let diagnoseDisplay = '';

                if (dataDiagnosis && Array.isArray(dataDiagnosis)) {
                    dataDiagnosis.forEach((diagnosis, index) => {
                        let uniqueId = 'diagnosis-' + index;

                        // Untuk modal diagnosis
                        diagnosisList += `
                        <li class="list-group-item d-flex justify-content-between align-items-center" id="${uniqueId}">
                            <span class="fw-bold">${diagnosis}</span>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-link edit-diagnosis" data-id="${uniqueId}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-link remove-diagnosis" data-id="${uniqueId}">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </div>
                        </li>`;

                        // Untuk tampilan utama
                        diagnoseDisplay += `
                        <div class="diagnosis-item d-flex justify-content-between align-items-center mb-2"
                            id="main-${uniqueId}" data-diagnosis="${diagnosis}">
                            <div class="d-flex align-items-center gap-2">
                                <span class="drag-handle" style="cursor: move;">
                                    <i class="bi bi-grip-vertical"></i>
                                </span>
                                <span class="fw-bold">${diagnosis}</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-link remove-main-diagnosis" data-id="${uniqueId}">
                                <i class="bi bi-x-circle text-danger"></i>
                            </button>
                        </div>`;
                    });
                }

                // Update tampilan
                $('#diagnosisList').html(diagnosisList);
                $('.diagnosis-list').html(diagnoseDisplay);

                // Update hidden input dengan JSON string
                $('#diagnosisData').val(JSON.stringify(dataDiagnosis));

                // Initialize Sortable
                initializeSortable();
            }

            // Inisialisasi Sortable
            function initializeSortable() {
                let diagnosisList = document.querySelector('.diagnosis-list');
                if (diagnosisList) {
                    new Sortable(diagnosisList, {
                        animation: 150,
                        handle: '.drag-handle',
                        onEnd: function(evt) {
                            // Buat array baru dari urutan setelah drag
                            let newOrder = [];
                            $('.diagnosis-item').each(function() {
                                let diagnosis = $(this).data('diagnosis');
                                if (diagnosis && !newOrder.includes(diagnosis)) {
                                    newOrder.push(diagnosis);
                                }
                            });

                            // Update dataDiagnosis dengan array baru tanpa duplikat
                            dataDiagnosis = newOrder;

                            // Update hidden input
                            $('#diagnosisData').val(JSON.stringify(dataDiagnosis));

                            // Refresh tampilan
                            displayDiagnosis();
                        }
                    });
                }
            }

            // Tampilkan data awal
            displayDiagnosis();

            // Buka modal
            $('#btn-diagnosis').on('click', function() {
                displayDiagnosis();
                $('#modal-create-diagnosis').modal('show');
            });

            // Tambah diagnosis
            $('#btnAddDiagnosis').click(function() {
                var diagnosis = $('#searchDiagnosisInput').val().trim();
                if (diagnosis !== '') {
                    // Cek apakah diagnosis sudah ada
                    if (!dataDiagnosis.includes(diagnosis)) {
                        dataDiagnosis.push(diagnosis);
                        displayDiagnosis();
                    }
                    $('#searchDiagnosisInput').val('');
                }
            });

            // Handle enter key
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

            // Hapus diagnosis
            $(document).on('click', '.remove-diagnosis, .remove-main-diagnosis', function() {
                var diagnosisId = $(this).data('id');
                var index = diagnosisId.split('-')[1];
                if (index >= 0 && index < dataDiagnosis.length) {
                    dataDiagnosis.splice(index, 1);
                    displayDiagnosis();
                }
            });

            // Simpan diagnosis
            $('#btnSaveDiagnose').click(function() {
                // Pastikan tidak ada duplikat sebelum menyimpan
                dataDiagnosis = removeDuplicates(dataDiagnosis);
                displayDiagnosis();
                $('#modal-create-diagnosis').modal('hide');
            });
        });
    </script>
@endpush
