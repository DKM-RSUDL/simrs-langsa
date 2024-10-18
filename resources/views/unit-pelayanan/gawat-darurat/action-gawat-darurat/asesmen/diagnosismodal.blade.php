<!-- Button untuk membuka modal kedua -->
<button class="btn btn-sm" id="openDiagnosisModal">
    <i class="bi bi-plus-square"></i> Tambah
</button>

<div class="modal fade" id="addDiagnosisModal" tabindex="-1" aria-labelledby="addDiagnosisModalLabel" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDiagnosisModalLabel">Input Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">
                    Tambah Diagnosis
                </h6>
                <p class="text-muted">
                    (Isi diagnosis pada kolom dibawah dan Tekan tambah untuk menambah ke daftar diagnosis. Satu baris
                    untuk satu diagnosis )
                </p>
                <div class="dropdown">
                    <input type="text" class="form-control dropdown-toggle" id="searchInput"
                        placeholder="Nama Diagnosis" aria-expanded="false" autocomplete="off">
                    <ul class="dropdown-menu" id="dataList" aria-labelledby="searchInput">
                    </ul>
                </div>
                <button type="button" id="btnAddListDiagnosa"
                    class="btn btn-sm btn-primary mt-2 float-end">Tambah</button>

                <h6 class="fw-bold mt-5">Daftar Diagnosis</h6>
                <ol type="1" id="listDiagnosa">
                    {{-- <li>HYPERTENSI KRONIS</li> --}}
                </ol>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveDiagnose" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var mainModal = document.querySelector('.modal:not(#addDiagnosisModal)');
        var diagnosisModal = new bootstrap.Modal(document.getElementById('addDiagnosisModal'));
        var diagnoseList = document.getElementById('diagnoseList');
        var listDiagnosa = document.getElementById('listDiagnosa');
        var diagnoses = []; // Array untuk menyimpan daftar diagnosis

        function updateMainView() {
            diagnoseList.innerHTML = diagnoses.map(d => `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>${d}</span>
                    <button class="btn btn-sm btn-danger delete-main-diagnosis">&times;</button>
                </div>
            `).join('');
        }

        function updateModalView() {
            listDiagnosa.innerHTML = diagnoses.map(d => `<li>${d}</li>`).join('');
        }

        document.getElementById('openDiagnosisModal').addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            updateModalView(); // Update modal view before showing
            diagnosisModal.show();
        });

        document.getElementById('btnAddListDiagnosa').addEventListener('click', function() {
            var diagnosisInput = document.getElementById('searchInput');
            if (diagnosisInput.value.trim() !== '') {
                diagnoses.push(diagnosisInput.value.trim());
                updateModalView();
                diagnosisInput.value = '';
            }
        });

        document.getElementById('btnSaveDiagnose').addEventListener('click', function() {
            updateMainView();
            diagnosisModal.hide();
        });

        // Event delegation for delete buttons in main view
        diagnoseList.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-main-diagnosis')) {
                var index = Array.from(diagnoseList.children).indexOf(e.target.closest('div'));
                diagnoses.splice(index, 1);
                updateMainView();
            }
        });

        // Prevent diagnosis modal from closing main modal
        document.getElementById('addDiagnosisModal').addEventListener('hidden.bs.modal', function(event) {
            event.stopPropagation();
        });
    });
</script>