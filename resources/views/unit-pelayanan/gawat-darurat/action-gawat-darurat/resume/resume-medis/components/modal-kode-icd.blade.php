<div class="modal fade" id="modal-kode-icd" tabindex="-1" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="smallModalLabel">Cari dan pilih kode ICD-10</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-3">
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari kode ICD-10..."
                        autocomplete="off">
                    <ul class="list-group mt-2" id="dataList" style="max-height: 200px; overflow-y: auto;"></ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" id="btnPilih">Pilih</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const searchInput = $('#searchInput');
        const dataList = $('#dataList');
        const btnPilih = $('#btnPilih');
        const icdList = $('#icdList'); // Element untuk menambah kode ICD di modal utama

        // Data ICD-10 dari database
        const icdData = @json($kodeICD);

        // Fungsi pencarian
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

        // Pilih item dari daftar
        dataList.on('click', 'li', function() {
            dataList.find('li').removeClass('active');
            $(this).addClass('active');
        });

        // Ketika tombol pilih ditekan
        btnPilih.on('click', function() {
            const selectedItem = dataList.find('li.active').text();
            if (selectedItem) {
                const selectedCode = selectedItem.split(' - ')[0];
                const selectedDescription = selectedItem.split(' - ')[1];

                const newItem = `<li class="list-group-item d-flex justify-content-between align-items-center">
                    ${selectedCode} - ${selectedDescription}
                    <button type="button" class="btn btn-danger btn-sm remove-icd mt-2">X</button>
                </li>`;
                icdList.append(newItem);

                // Tutup modal setelah memilih
                $('#modal-kode-icd').modal('hide');
            } else {
                alert('Silakan pilih item terlebih dahulu');
            }
        });

        // Hapus kode ICD ketika tombol X ditekan
        icdList.on('click', '.remove-icd', function() {
            $(this).closest('li').remove();
        });

        // Reset modal ketika dibuka kembali
        $('#btn-kode-icd').on('click', function() {
            $('#modal-kode-icd').modal('show');
            searchInput.val('');
            dataList.empty();
        });
    });
</script>
