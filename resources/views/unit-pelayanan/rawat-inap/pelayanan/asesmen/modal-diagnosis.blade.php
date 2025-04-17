<!-- Button untuk membuka modal diagnosis -->
<button class="btn btn-sm" id="openDiagnosisModalUnique">
    <i class="bi bi-plus-square"></i> Tambah
</button>

<div class="modal fade" id="diagnosisModalUnique" tabindex="-1" aria-labelledby="diagnosisModalLabelUnique" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="diagnosisModalLabelUnique">Input Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">
                    Tambah Diagnosis
                </h6>
                <p class="text-muted">
                    (Isi diagnosis pada kolom dibawah dan tekan tambah untuk menambah ke daftar diagnosis. Satu baris
                    untuk satu diagnosis)
                </p>
                <div class="dropdown">
                    <input type="text" class="form-control dropdown-toggle" id="searchDiagnosisInputUnique"
                        placeholder="Nama Diagnosis" aria-expanded="false" autocomplete="off">
                    <ul class="dropdown-menu" id="dataListUnique" aria-labelledby="searchDiagnosisInputUnique">
                    </ul>
                </div>
                <button type="button" id="btnAddDiagnosisUnique"
                    class="btn btn-sm btn-primary mt-2 float-end">Tambah</button>

                <h6 class="fw-bold mt-5">Daftar Diagnosis</h6>
                <ol type="1" id="diagnosisListUnique">
                    {{-- <li>HYPERTENSI KRONIS</li> --}}
                </ol>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveDiagnosisUnique" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var diagnosisModal = new bootstrap.Modal(document.getElementById('diagnosisModalUnique'));
            var diagnoseMainList = document.getElementById('diagnoseList');
            var diagnosisList = document.getElementById('diagnosisListUnique');
            var diagnoses = []; // Array untuk menyimpan daftar diagnosis

            function updateMainView() {
                diagnoseMainList.innerHTML = diagnoses.map(d => `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>${d}</span>
                        <button class="btn btn-sm btn-danger delete-main-diagnosis">&times;</button>
                    </div>
                `).join('');
            }

            function updateModalView() {
                diagnosisList.innerHTML = diagnoses.map(d => `<li>${d}</li>`).join('');
            }

            document.getElementById('openDiagnosisModalUnique').addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                updateModalView(); // Update modal view before showing
                diagnosisModal.show();
            });

            document.getElementById('btnAddDiagnosisUnique').addEventListener('click', function() {
                var diagnosisInput = document.getElementById('searchDiagnosisInputUnique');
                if (diagnosisInput.value.trim() !== '') {
                    diagnoses.push(diagnosisInput.value.trim());
                    updateModalView();
                    diagnosisInput.value = '';
                }
            });

            document.getElementById('btnSaveDiagnosisUnique').addEventListener('click', function() {
                updateMainView();
                diagnosisModal.hide();
            });

            // Event delegation for delete buttons in main view
            diagnoseMainList.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-main-diagnosis')) {
                    var index = Array.from(diagnoseMainList.children).indexOf(e.target.closest('div'));
                    diagnoses.splice(index, 1);
                    updateMainView();
                }
            });

            // Prevent diagnosis modal from closing main modal
            document.getElementById('diagnosisModalUnique').addEventListener('hidden.bs.modal', function(event) {
                event.stopPropagation();
            });

            window.getDiagnosaData = function() {
                return JSON.stringify(diagnoses);
            };
        });
    </script>
@endpush
