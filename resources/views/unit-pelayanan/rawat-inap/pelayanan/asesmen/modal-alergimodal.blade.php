<button class="btn btn-sm" id="openAlergiModal">
    <i class="bi bi-plus-square"></i> Tambah
</button>

<!-- Modal Alergi -->
<div class="modal fade" id="ranapAddAlergiModal" tabindex="-1" aria-labelledby="ranapAddAlergiModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ranapAddAlergiModalLabel">Input Alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">Tambah Alergi</h6>
                <p class="text-muted">(Isi informasi alergi pada kolom di bawah dan Tekan tambah untuk menambah ke daftar alergi)</p>
                <div class="mb-3">
                    <select class="form-select" id="jenisAlergiInput">
                        <option value="">Pilih Jenis</option>
                        <option value="Obat">Obat</option>
                        <option value="Makanan">Makanan</option>
                        <option value="Udara">Udara</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="alergenInput" placeholder="Nama Alergen" autocomplete="off">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="reaksiInput" placeholder="Reaksi" autocomplete="off">
                </div>
                <div class="mb-3">
                    <select class="form-select" id="tingkatKeparahanInput">
                        <option value="">Pilih Tingkat Keparahan</option>
                        <option value="Ringan">Ringan</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Berat">Berat</option>
                    </select>
                </div>
                <button type="button" id="btnAddListAlergi" class="btn btn-sm btn-primary mt-2 float-end">Tambah</button>

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
            var mainModal = document.querySelector('.modal:not(#ranapAddAlergiModal)');
            var alergiModal = new bootstrap.Modal(document.getElementById('ranapAddAlergiModal'));
            var alergiTable = document.querySelector('#createAlergiTableRanap tbody');
            var listAlergi = document.getElementById('listAlergi');
            var alergis = []; // Array untuk menyimpan daftar alergi

            function updateMainView() {
                alergiTable.innerHTML = alergis.map((a, index) => `
                    <tr>
                        <td>${a.jenis}</td>
                        <td>${a.alergen}</td>
                        <td>${a.reaksi}</td>
                        <td>${a.keparahan}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-link delete-main-alergi" data-index="${index}"><i class="bi bi-trash-fill text-danger"></i></button>
                        </td>
                    </tr>
                `).join('');
            }

            function updateModalView() {
                listAlergi.innerHTML = alergis.map(a => `<li>${a.jenis} - ${a.alergen} - ${a.reaksi} (${a.keparahan})</li>`).join('');
            }

            document.getElementById('openAlergiModal').addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                updateModalView(); // Update modal view before showing
                alergiModal.show();
            });

            document.getElementById('btnAddListAlergi').addEventListener('click', function() {
                var jenisAlergiInput = document.getElementById('jenisAlergiInput');
                var alergenInput = document.getElementById('alergenInput');
                var reaksiInput = document.getElementById('reaksiInput');
                var keparahanInput = document.getElementById('tingkatKeparahanInput');

                if (jenisAlergiInput.value.trim() !== '' && alergenInput.value.trim() !== '' && reaksiInput.value.trim() !== '' && keparahanInput.value !== '') {
                    alergis.push({
                        jenis: jenisAlergiInput.value.trim(),
                        alergen: alergenInput.value.trim(),
                        reaksi: reaksiInput.value.trim(),
                        keparahan: keparahanInput.value
                    });
                    updateModalView();

                    jenisAlergiInput.value = '';
                    alergenInput.value = '';
                    reaksiInput.value = '';
                    keparahanInput.value = '';
                } else {
                    alert('Harap isi semua field alergi');
                }
            });

            document.getElementById('btnSaveAlergi').addEventListener('click', function() {
                updateMainView();
                alergiModal.hide();
            });

            // Event delegation for delete buttons in main view
            alergiTable.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-main-alergi')) {
                    var index = parseInt(e.target.dataset.index);
                    alergis.splice(index, 1);
                    updateMainView();
                }
            });

            // Prevent alergi modal from closing main modal
            document.getElementById('ranapAddAlergiModal').addEventListener('hidden.bs.modal', function(event) {
                event.stopPropagation();
            });

            // Add this function to get alergi data for form submission
            window.getAlergiData = function() {
                return JSON.stringify(alergis);
            };
        });
    </script>
@endpush
