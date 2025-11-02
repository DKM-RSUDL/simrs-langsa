<div class="modal fade" id="modal-kode-icd" tabindex="-1" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="smallModalLabel">Cari dan pilih kode ICD-10</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="searchInput" class="form-label">ICD-10</label>
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari kode ICD-10..."
                        autocomplete="off">
                    <ul class="list-group mt-2" id="dataList" style="max-height: 200px; overflow-y: auto;"></ul>
                </div>

                <div class="form-group mt-3">
                    <label for="stat_diag" class="form-label">Status Diagnosa</label>
                    <select name="stat_diag" id="stat_diag" class="form-select">
                        <option value="">--Pilih--</option>
                        <option value="0">Utama</option>
                        <option value="3">Sekunder</option>
                        <option value="1">Diagnosa awal</option>
                        <option value="3">Komplikasi</option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="kasus" class="form-label">Kasus</label>
                    <select name="kasus" id="kasus" class="form-select">
                        <option value="">--Pilih--</option>
                        <option value="0">Baru</option>
                        <option value="1">Lama</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" id="btnPilih">Pilih</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        let penyakitList = @json($dataResume->icd_10 ?? []);

        $(document).ready(function() {
            const searchInput = $('#searchInput');
            const dataList = $('#dataList');
            const btnPilih = $('#btnPilih');
            const icdList = $('#icdList');
            let $modal = $('#modal-kode-icd');

            // Data ICD-10 dari database
            const icdData = @json($kodeICD);

            function statDiagLabel(value) {
                switch (value) {
                    case '0':
                        return 'Utama';
                    case '1':
                        return 'Diagnosa awal';
                    case '2':
                        return 'Komplikasi';
                    case '3':
                        return 'Sekunder';
                    default:
                        return '';
                }
            }

            function kasusLabel(value) {
                switch (value) {
                    case '0':
                        return 'Baru';
                    case '1':
                        return 'Lama';
                    default:
                        return '';
                }
            }

            // Fungsi untuk menampilkan ICD-10 yang sudah ada
            function displayExistingICD() {
                icdList.empty();
                if (Array.isArray(penyakitList) && penyakitList.length > 0) {
                    penyakitList.forEach((penyakit, index) => {
                        const newItem = `<li class="list-group-item d-flex justify-content-between align-items-center" data-index="${index}">
                                            ${penyakit.kd_penyakit} - ${statDiagLabel(penyakit.stat_diag)} - ${kasusLabel(penyakit.kasus)}
                                            <button type="button" class="btn remove-icd mt-2"><i class="fas fa-times text-danger"></i></button>
                                        </li>`;

                        icdList.append(newItem);
                    });
                }
            }

            // Tampilkan ICD-10 yang sudah ada
            displayExistingICD();

            //pencarian
            searchInput.on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                const filteredData = icdData.filter(item =>
                    item.kd_penyakit.toLowerCase().includes(searchTerm) ||
                    item.penyakit.toLowerCase().includes(searchTerm)
                );

                dataList.empty();
                filteredData.forEach(item => {
                    dataList.append(
                        `<li class="list-group-item">${item.kd_penyakit} - ${item.penyakit}</li>`
                    );
                });
            });

            // Pilih yang daftar
            dataList.on('click', 'li', function() {
                dataList.find('li').removeClass('active');
                $(this).addClass('active');
            });

            // Ketika tombol pilih ditekan
            btnPilih.on('click', function() {
                const selectedItem = dataList.find('li.active').text();

                let statDiag = $modal.find('#stat_diag').val();
                let kasus = $modal.find('#kasus').val();

                if (selectedItem && statDiag && kasus) {
                    let kdPenyakit = selectedItem.split(' - ')[0];

                    const isExist = penyakitList.some(item => item.kd_penyakit === kdPenyakit);

                    if (!isExist) {
                        penyakitList.push({
                            kd_penyakit: kdPenyakit,
                            stat_diag: statDiag,
                            kasus: kasus
                        });

                        displayExistingICD();
                    } else {
                        alert('Kode ICD-10 ini sudah ada dalam daftar');
                    }

                    // Tutup modal
                    $modal.modal('hide');
                } else {
                    alert('Inputan tidak lengkap');
                }
            });

            // Hapus kode ICD X
            icdList.on('click', '.remove-icd', function() {
                const index = $(this).closest('li').data('index');
                penyakitList.splice(index, 1);
                displayExistingICD();
            });

            // Reset modal
            $('#btn-kode-icd').on('click', function() {
                let $modal = $('#modal-kode-icd');
                $modal.modal('show');
                searchInput.val('');
                $modal.find('#stat_diag').val('');
                $modal.find('#kasus').val('');
                dataList.empty();
            });
        });
    </script>
@endpush
