<!-- Modal Alergi -->
<div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alergiModalLabel">Input Alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">Tambah Alergi</h6>
                <p class="text-muted">(Isi informasi alergi pada kolom di bawah dan Tekan tambah untuk menambah ke
                    daftar alergi)</p>

                <div class="mb-3">
                    <select class="form-select" id="jenisInput">
                        <option value="">Pilih Jenis Alergi</option>
                        <option value="Obat">Obat</option>
                        <option value="Makanan">Makanan</option>
                        <option value="Udara">Udara</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" id="alergenInput" placeholder="Alergen"
                        autocomplete="off">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="reaksiInput" placeholder="Reaksi" autocomplete="off">
                </div>
                <div class="mb-3">
                    <select class="form-select" id="severeInput">
                        <option value="">Pilih Tingkat Keparahan</option>
                        <option value="Ringan">Ringan</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Berat">Berat</option>
                    </select>
                </div>
                <button type="button" id="btnAddAlergi" class="btn btn-sm btn-primary mt-2 float-end">Tambah</button>

                <h6 class="fw-bold mt-5">Daftar Alergi</h6>
                <ul id="listAlergi"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveAlergi" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alergiModalElement = document.getElementById('alergiModal');
            var alergiModal = new bootstrap.Modal(alergiModalElement);
            var alergiTable = document.querySelector('#createAlergiTable tbody');
            var listAlergi = document.getElementById('listAlergi');
            var alergis = [];

            function updateMainView() {
                if (alergis.length === 0) {
                    alergiTable.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">Tidak ada alergi, silahkan tambah</td>
                        </tr>
                    `;
                } else {
                    alergiTable.innerHTML = alergis.map((a, index) => `
                        <tr>
                            <td>${a.jenis}</td>
                            <td>${a.alergen}</td>
                            <td>${a.reaksi}</td>
                            <td>${a.severe}</td>
                            <td>
                                <button class="btn btn-sm btn-link delete-alergi" data-index="${index}">
                                    <i class="fas fa-times text-danger"></i>
                                </button>
                            </td>
                        </tr>
                    `).join('');
                }
                document.getElementById('alergisInput').value = JSON.stringify(alergis);
            }

            function updateModalView() {
                if (alergis.length === 0) {
                    listAlergi.innerHTML = '<li class="text-muted">Tidak ada alergi</li>';
                } else {
                    listAlergi.innerHTML = alergis.map(a => `
                        <li class="mb-2">
                            <span class="fw-bold">${a.jenis}</span>: ${a.alergen} - ${a.reaksi}
                            <span class="badge bg-warning">${a.severe}</span>
                        </li>
                    `).join('');
                }
            }

            document.getElementById('openAlergiModal').addEventListener('click', function() {
                updateModalView();
                alergiModal.show();
            });

            document.getElementById('btnAddAlergi').addEventListener('click', function() {
                var jenisInput = document.getElementById('jenisInput').value;
                var alergenInput = document.getElementById('alergenInput').value.trim();
                var reaksiInput = document.getElementById('reaksiInput').value.trim();
                var severeInput = document.getElementById('severeInput').value;

                if (jenisInput === '' || alergenInput === '' || reaksiInput === '' || severeInput === '') {
                    alert('Harap isi semua field alergi');
                    return;
                }

                alergis.push({
                    jenis: jenisInput,
                    alergen: alergenInput,
                    reaksi: reaksiInput,
                    severe: severeInput
                });
                updateModalView();

                // Reset inputs
                document.getElementById('jenisInput').value = '';
                document.getElementById('alergenInput').value = '';
                document.getElementById('reaksiInput').value = '';
                document.getElementById('severeInput').value = '';
            });

            document.getElementById('btnSaveAlergi').addEventListener('click', function() {
                updateMainView();
                alergiModal.hide();
            });

            // Handle modal hidden event to ensure backdrop is removed
            alergiModalElement.addEventListener('hidden.bs.modal', function() {
                document.body.classList.remove('modal-open');
                var backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            });

            // Event delegation for delete buttons
            alergiTable.addEventListener('click', function(e) {
                if (e.target.closest('.delete-alergi')) {
                    var row = e.target.closest('tr');
                    var index = Array.from(row.parentElement.children).indexOf(row);
                    alergis.splice(index, 1);
                    updateMainView();
                }
            });

            alergis = [];
            updateMainView();
        });
    </script>
@endpush
