<!-- Button untuk membuka modal alergi -->
<button class="btn btn-sm" id="openAlergiModalUnique">
    <i class="bi bi-plus-square"></i> Tambah
</button>

<div class="modal fade" id="alergiModalUnique" tabindex="-1" aria-labelledby="alergiModalLabelUnique" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alergiModalLabelUnique">Input alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">
                    Tambah alergi
                </h6>
                <p class="text-muted">
                    (Isi alergi pada kolom dibawah dan tekan tambah untuk menambah ke daftar alergi. Satu baris
                    untuk satu alergi)
                </p>
                <div class="dropdown">
                    <input type="text" class="form-control dropdown-toggle" id="searchAlergiInputUnique"
                        placeholder="Nama Alergi" aria-expanded="false" autocomplete="off">
                    <ul class="dropdown-menu" id="dataListUnique" aria-labelledby="searchAlergiInputUnique">
                    </ul>
                </div>
                <button type="button" id="btnAddAlergiUnique"
                    class="btn btn-sm btn-primary mt-2 float-end">Tambah</button>

                <h6 class="fw-bold mt-5">Daftar Alergi</h6>
                <ol type="1" id="alergiListUnique">
                    {{-- <li>HYPERTENSI KRONIS</li> --}}
                </ol>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveAlergiUnique" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var alergiModal = new bootstrap.Modal(document.getElementById('alergiModalUnique'));
        var diagnoseMainList = document.getElementById('alergiList');
        var alergiList = document.getElementById('alergiListUnique');
        var diagnoses = []; // Array untuk menyimpan daftar alergi

        function updateMainView() {
            diagnoseMainList.innerHTML = diagnoses.map(d => `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>${d}</span>
                    <button class="btn btn-sm btn-danger delete-main-alergi">&times;</button>
                </div>
            `).join('');
        }

        function updateModalView() {
            alergiList.innerHTML = diagnoses.map(d => `<li>${d}</li>`).join('');
        }

        document.getElementById('openAlergiModalUnique').addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            updateModalView(); // Update modal view before showing
            alergiModal.show();
        });

        document.getElementById('btnAddAlergiUnique').addEventListener('click', function() {
            var alergiInput = document.getElementById('searchAlergiInputUnique');
            if (alergiInput.value.trim() !== '') {
                diagnoses.push(alergiInput.value.trim());
                updateModalView();
                alergiInput.value = '';
            }
        });

        document.getElementById('btnSaveAlergiUnique').addEventListener('click', function() {
            updateMainView();
            alergiModal.hide();
        });

        // Event delegation for delete buttons in main view
        diagnoseMainList.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-main-alergi')) {
                var index = Array.from(diagnoseMainList.children).indexOf(e.target.closest('div'));
                diagnoses.splice(index, 1);
                updateMainView();
            }
        });

        // Prevent alergi modal from closing main modal
        document.getElementById('alergiModalUnique').addEventListener('hidden.bs.modal', function(event) {
            event.stopPropagation();
        });

        window.getDiagnosaData = function() {
            return JSON.stringify(diagnoses);
        };
    });
</script>
