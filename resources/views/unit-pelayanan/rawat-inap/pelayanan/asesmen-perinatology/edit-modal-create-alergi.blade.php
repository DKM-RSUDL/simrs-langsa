<!-- Modal Alergi -->
<div class="modal fade" id="editAlergiModal" tabindex="-1" aria-labelledby="editAlergiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAlergiModalLabel">Edit Alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">Tambah Alergi</h6>
                <p class="text-muted">(Isi informasi alergi pada kolom di bawah dan tekan tambah untuk menambah ke
                    daftar alergi)</p>

                <!-- Select untuk jenis di modal -->
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
                <ul id="listAlergi">
                    <li class="text-muted" id="emptyListMessage">Tidak ada alergi</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btnSaveAlergi" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup Bootstrap modal
            var alergiModal = document.getElementById('editAlergiModal');

            // Pastikan modal sudah dimuat
            if (!alergiModal) {
                console.error('Modal Alergi tidak ditemukan!');
                return;
            }

            var bsAlergiModal = new bootstrap.Modal(alergiModal);

            // Elements
            var alergiTable = document.querySelector('#createAlergiTable tbody');
            var listAlergi = document.getElementById('listAlergi');
            var emptyListMessage = document.getElementById('emptyListMessage');
            var alergis = []; // Array untuk menyimpan daftar alergi

            // Cek jika ada data alergi yang sudah ada
            try {
                var existingData = document.getElementById('alergisInput').value;

                if (existingData && existingData !== "[]") {
                    try {
                        var parsedData = JSON.parse(existingData);

                        // Handle berbagai format data
                        if (Array.isArray(parsedData)) {
                            // Format array of objects
                            alergis = parsedData.map(function(item) {
                                return {
                                    jenis: item.jenis || '',
                                    alergen: item.alergen || '',
                                    reaksi: item.reaksi || '',
                                    severe: item.severe || item.keparahan || ''
                                };
                            });
                        } else if (typeof parsedData === 'object') {
                            // Format lain
                            var convertedData = [];
                            for (var key in parsedData) {
                                if (parsedData.hasOwnProperty(key)) {
                                    convertedData.push({
                                        jenis: key,
                                        alergen: parsedData[key].alergen || '',
                                        reaksi: parsedData[key].reaksi || '',
                                        severe: parsedData[key].severe || parsedData[key].keparahan || ''
                                    });
                                }
                            }
                            alergis = convertedData;
                        }


                        // Update table dengan data yang sudah ada
                        updateMainView();
                    } catch (e) {
                        console.error('Error parsing JSON data:', e);
                    }
                }
            } catch (e) {
                console.error('Error loading existing data:', e);
            }

            // Update main table view
            function updateMainView() {

                if (alergis.length === 0) {
                    alergiTable.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada alergi, silahkan tambah</td>
                    </tr>
                `;
                } else {
                    alergiTable.innerHTML = '';
                    for (var i = 0; i < alergis.length; i++) {
                        var alergi = alergis[i];
                        var row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${alergi.jenis || ''}</td>
                        <td>${alergi.alergen || ''}</td>
                        <td>${alergi.reaksi || ''}</td>
                        <td>${alergi.severe || ''}</td>
                        <td>
                            <button class="btn btn-sm btn-danger delete-alergi" data-index="${i}">
                                <i class="fas fa-times"></i> Hapus
                            </button>
                        </td>
                    `;
                        alergiTable.appendChild(row);
                    }
                }

                // Update hidden input
                document.getElementById('alergisInput').value = JSON.stringify(alergis);
            }

            // Update modal list view
            function updateModalList() {

                if (alergis.length === 0) {
                    emptyListMessage.style.display = 'block';
                    listAlergi.innerHTML = '<li class="text-muted" id="emptyListMessage">Tidak ada alergi</li>';
                } else {
                    emptyListMessage.style.display = 'none';
                    listAlergi.innerHTML = '';

                    for (var i = 0; i < alergis.length; i++) {
                        var alergi = alergis[i];
                        var item = document.createElement('li');
                        item.textContent =
                            `${alergi.alergen || ''} - ${alergi.reaksi || ''} (${alergi.severe || ''})`;
                        listAlergi.appendChild(item);
                    }
                }
            }

            // Add alergi from modal
            document.getElementById('btnAddAlergi').addEventListener('click', function() {
                var jenisInput = document.getElementById('jenisInput');
                var alergenInput = document.getElementById('alergenInput');
                var reaksiInput = document.getElementById('reaksiInput');
                var severeInput = document.getElementById('severeInput');

                if (jenisInput.value.trim() && alergenInput.value.trim() && reaksiInput.value.trim() &&
                    severeInput.value) {
                    alergis.push({
                        jenis: jenisInput.value.trim(),
                        alergen: alergenInput.value.trim(),
                        reaksi: reaksiInput.value.trim(),
                        severe: severeInput.value
                    });

                    // Clear form inputs
                    jenisInput.value = '';
                    alergenInput.value = '';
                    reaksiInput.value = '';
                    severeInput.value = '';

                    // Update modal list
                    updateModalList();
                } else {
                    alert('Harap isi semua field alergi');
                }
            });

            // Save button in modal
            document.getElementById('btnSaveAlergi').addEventListener('click', function() {
                updateMainView();
                bsAlergiModal.hide();
            });

            // Delete alergi
            alergiTable.addEventListener('click', function(e) {
                if (e.target.closest('.delete-alergi')) {
                    var button = e.target.closest('.delete-alergi');
                    var index = parseInt(button.getAttribute('data-index'));

                    if (!isNaN(index) && index >= 0 && index < alergis.length) {
                        alergis.splice(index, 1);
                        updateMainView();
                    }
                }
            });

            // Open modal button
            document.getElementById('openAlergiModal').addEventListener('click', function(e) {
                updateModalList();
                bsAlergiModal.show();
            });

            // Initialize
            updateMainView();
        });
    </script>
@endpush
