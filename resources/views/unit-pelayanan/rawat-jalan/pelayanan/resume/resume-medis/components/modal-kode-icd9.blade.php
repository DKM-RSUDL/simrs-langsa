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
    let icd_9 = @json($dataResume->icd_9 ?? []);
    // console.log(icd_9);

    $(document).ready(function() {
        const searchInput9 = $('#searchInput9');
        const dataList9 = $('#dataList9');
        const btnPilih9 = $('#btnPilih9');
        const icdList9 = $('#icd9List');

        // Data ICD-9 CM dari server
        const icdData9 = @json($kodeICD9);

        // menampilkan ICD-9 yang sudah ada
        function displayExistingICD9() {
            icdList9.empty();
            if (Array.isArray(icd_9)) {
                icd_9.forEach((icd, index) => {
                    const [code] = icd.split(' - ');
                    const newItem = `<li class="list-group-item d-flex justify-content-between align-items-center" data-index="${index}">
                    ${code}
                    <button type="button" class="btn btn-danger btn-sm remove-icd9 mt-2">X</button>
                </li>`;
                    icdList9.append(newItem);
                });
            }
        }
        displayExistingICD9();

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
                if (!icd_9.includes(selectedItem)) {
                    icd_9.push(selectedItem);
                    displayExistingICD9();
                } else {
                    alert('Kode ICD-9 ini sudah ada dalam daftar');
                }
                // Tutup modal
                $('#modal-kode-icd9').modal('hide');
            } else {
                alert('Silakan pilih item terlebih dahulu');
            }
        });

        // Menghapus item dari modal utama
        icdList9.on('click', '.remove-icd9', function() {
            const index = $(this).closest('li').data('index');
            icd_9.splice(index, 1);
            displayExistingICD9();
        });

        // Reset modal
        $('#btn-kode-icd9').on('click', function() {
            $('#modal-kode-icd9').modal('show');
            searchInput9.val('');
            dataList9.empty();
        });

        // Simpan perubahan
        $('#btnSaveChanges').on('click', function() {
            // Kirim data icd_9 ke server menggunakan AJAX
            $.ajax({
                url: '/update-icd-9', // Ganti dengan URL
                method: 'POST',
                data: {
                    icd_9: JSON.stringify(icd_9)
                },
                success: function(response) {
                    alert('Data ICD-9 berhasil disimpan');
                },
                error: function() {
                    alert('Terjadi kesalahan saat menyimpan data');
                }
            });
        });
    });
</script>
