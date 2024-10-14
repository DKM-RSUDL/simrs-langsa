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

        // Contoh data ICD-10 sederhana
        const icdData = [{
                code: 'A00',
                description: 'Cholera'
            },
            {
                code: 'A01',
                description: 'Typhoid fever'
            },
            {
                code: 'B01',
                description: 'Varicella [chickenpox]'
            },
            {
                code: 'C50',
                description: 'Malignant neoplasm of breast'
            }
        ];

        searchInput.on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            const filteredData = icdData.filter(item =>
                item.code.toLowerCase().includes(searchTerm) ||
                item.description.toLowerCase().includes(searchTerm)
            );

            dataList.empty();
            filteredData.forEach(item => {
                dataList.append(
                    `<li class="list-group-item">${item.code} - ${item.description}</li>`);
            });
        });

        dataList.on('click', 'li', function() {
            dataList.find('li').removeClass('active');
            $(this).addClass('active');
        });

        btnPilih.on('click', function() {
            const selectedItem = dataList.find('li.active').text();
            if (selectedItem) {
                alert('Anda memilih: ' + selectedItem);
                $('#modal-kode-icd').modal('hide');
            } else {
                alert('Silakan pilih item terlebih dahulu');
            }
        });

        $('#btn-kode-icd').on('click', function() {
            $('#modal-kode-icd').modal('show');
            searchInput.val('');
            dataList.empty();
        });
    });
</script>
