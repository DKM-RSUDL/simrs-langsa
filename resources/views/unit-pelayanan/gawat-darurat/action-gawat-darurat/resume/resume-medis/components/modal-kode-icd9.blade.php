<div class="modal fade" id="modal-kode-icd9" tabindex="-1" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="smallModalLabel">Cari dan pilih kode ICD-9</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-3">
                    <input type="text" class="form-control" id="searchInput9" placeholder="Cari kode ICD-9..."
                        autocomplete="off">
                    <ul class="list-group mt-2" id="dataList9" style="max-height: 200px; overflow-y: auto;"></ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" id="btnPilih9">Pilih</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        const searchInput9 = $('#searchInput9');
        const dataList9 = $('#dataList9');
        const btnPilih9 = $('#btnPilih9');
        const icdList9 = $('#icd9List'); // Sesuaikan dengan ID di modal utama

        // Data ICD-9 CM dari server
        const icdData9 = @json($kodeICD9);

        // Fungsi pencarian
        searchInput9.on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            const filteredData = icdData9.filter(item =>
                item.code.toLowerCase().includes(searchTerm) ||
                item.description.toLowerCase().includes(searchTerm)
            );
            dataList9.empty();
            filteredData.forEach(item => {
                dataList9.append(
                    `<li class="list-group-item">${item.code} - ${item.description}</li>`
                );
            });
        });

        // Menandai item yang dipilih
        dataList9.on('click', 'li', function() {
            dataList9.find('li').removeClass('active');
            $(this).addClass('active');
        });

        // Ketika tombol pilih ditekan
        btnPilih9.on('click', function() {
            const selectedItem = dataList9.find('li.active').text();
            if (selectedItem) {
                const selectedCode = selectedItem.split(' - ')[0];
                const selectedDescription = selectedItem.split(' - ')[1];

                const newItem = `<li class="list-group-item d-flex justify-content-between align-items-center">
                    ${selectedCode} - ${selectedDescription}
                    <button type="button" class="btn btn-danger btn-sm remove-icd9 mt-2">X</button>
                </li>`;
                icdList9.append(newItem);

                // Tutup modal setelah memilih
                $('#modal-kode-icd9').modal('hide');
            } else {
                alert('Silakan pilih item terlebih dahulu');
            }
        });

        // Menghapus item modal utama
        icdList9.on('click', '.remove-icd9', function() {
            $(this).closest('li').remove();
        });

        // Reset modal
        $('#btn-kode-icd9').on('click', function() {
            $('#modal-kode-icd9').modal('show');
            searchInput9.val(''); // Reset pencarian
            dataList9.empty(); // Kosongkan list
        });
    });
</script>

