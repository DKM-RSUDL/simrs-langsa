<div class="modal fade" id="modal-tatalaksana-kfricd9" tabindex="-1" aria-labelledby="verticalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="verticalCenterLabel">Input Tatalaksana KFR (ICD-9 CM)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong class="fw-bold">Tambah Tatalaksana KFR (ICD-9 CM)</strong>
                    <div class="input-group mt-2">
                        <input type="text" class="form-control" id="searchTatalaksanaInput"
                            placeholder="Tatalaksana KFR (ICD-9 CM)">
                        <button type="button" class="btn btn-primary" id="btnAddTatalaksana">
                            Tambah
                        </button>
                    </div>
                </div>

                <div class="mt-3">
                    <strong class="fw-bold">Daftar Tatalaksana KFR (ICD-9 CM)</strong>
                    <div class="bg-light p-2 border rounded mt-2" style="max-height: 300px; overflow-y: auto;">
                        <ol type="1" id="tatalaksanaList" class="list-group list-group-flush"></ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btnSaveTatalaksana" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#btn-tatalaksana-kfricd9').on('click', function() {
            $('#modal-tatalaksana-kfricd9').modal('show');
        });

        $(document).ready(function() {
            // Initialize dataTatalaksana from server data or empty array
            let dataTatalaksana = @json($layanan->tatalaksana ?? []);

            // Function to display tatalaksana in both modal and main view
            function displayTatalaksana() {
                let tatalaksanaList = '';
                let tatalaksanaDisplay = '';

                dataTatalaksana.forEach((tatalaksana, index) => {
                    const uniqueId = `tatalaksana-${index}`;

                    // Modal list item
                    tatalaksanaList += `
                        <li class="list-group-item d-flex justify-content-between align-items-center" id="${uniqueId}">
                            <span class="tatalaksana-text">${tatalaksana}</span>
                            <div>
                                <a href="javascript:void(0)" class="edit-tatalaksana me-2" data-id="${uniqueId}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" class="remove-tatalaksana text-danger" data-id="${uniqueId}">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </li>
                    `;

                    // Main view display
                    tatalaksanaDisplay += `
                        <div class="d-flex justify-content-between align-items-center mb-2" id="main-${uniqueId}">
                            <span class="tatalaksana-text">${tatalaksana}</span>
                            <input type="hidden" name="tatalaksana[]" value="${tatalaksana}">

                            <a href="javascript:void(0)" class="remove-main-tatalaksana text-danger" data-id="${uniqueId}">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    `;
                });

                $('#tatalaksanaList').html(tatalaksanaList ||
                    '<p class="text-muted text-center my-3">Belum ada tatalaksana</p>');
                $('#diagnoseDisplaytatalaksanakfr').html(tatalaksanaDisplay ||
                    '<p class="text-muted text-center my-3">Belum ada tatalaksana</p>');
            }

            // Open main modal
            $('#btn-tatalaksana-kfricd9').on('click', function() {
                displayTatalaksana();
                $('#modal-tatalaksana-kfricd9').modal('show');
            });

            // Add new tatalaksana
            $('#btnAddTatalaksana').click(function() {
                const tatalaksana = $('#searchTatalaksanaInput').val().trim();

                if (tatalaksana) {
                    dataTatalaksana.push(tatalaksana);
                    displayTatalaksana();
                    $('#searchTatalaksanaInput').val('').focus();
                }
            });

            // Enter key handling for input
            $('#searchTatalaksanaInput').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btnAddTatalaksana').click();
                }
            });

            // Edit tatalaksana
            $(document).on('click', '.edit-tatalaksana', function() {
                const tatalaksanaId = $(this).data('id');
                const index = parseInt(tatalaksanaId.split('-')[1]);

                $('#editTatalaksanaTextarea').val(dataTatalaksana[index]);
                $('#editTatalaksanaId').val(index);
                $('#modal-edit-tatalaksana').modal('show');
            });

            // Update tatalaksana
            $('#btnUpdateTatalaksana').click(function() {
                const updatedTatalaksana = $('#editTatalaksanaTextarea').val().trim();
                const index = parseInt($('#editTatalaksanaId').val());

                if (updatedTatalaksana) {
                    dataTatalaksana[index] = updatedTatalaksana;
                    displayTatalaksana();
                    $('#modal-edit-tatalaksana').modal('hide');
                }
            });

            // Remove tatalaksana
            $(document).on('click', '.remove-tatalaksana, .remove-main-tatalaksana', function() {
                if (confirm('Apakah Anda yakin ingin menghapus tatalaksana ini?')) {
                    const tatalaksanaId = $(this).data('id');
                    const index = parseInt(tatalaksanaId.split('-')[1]);

                    dataTatalaksana.splice(index, 1);
                    displayTatalaksana();
                }
            });

            // Save tatalaksana
            $('#btnSaveTatalaksana').click(function() {
                displayTatalaksana();
                $('#modal-tatalaksana-kfricd9').modal('hide');
            });

            // Initial display
            displayTatalaksana();
        });
    </script>
@endpush
