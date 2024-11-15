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
    let icd_10 = @json($dataResume->icd_10 ?? []);
    // console.log(icd_10);

    $(document).ready(function() {
        const searchInput = $('#searchInput');
        const dataList = $('#dataList');
        const btnPilih = $('#btnPilih');
        const icdList = $('#icdList');

        // Data ICD-10 dari database
        const icdData = @json($kodeICD);

        // Fungsi untuk menampilkan ICD-10 yang sudah ada
        function displayExistingICD() {
            icdList.empty();
            if (Array.isArray(icd_10)) {
                icd_10.forEach((icd, index) => {
                    const [code] = icd.split(' - ');
                    const newItem = `<li class="list-group-item d-flex justify-content-between align-items-center" data-index="${index}">
                    ${code}
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
            if (selectedItem) {
                if (!icd_10.includes(selectedItem)) {
                    icd_10.push(selectedItem);
                    displayExistingICD();
                } else {
                    alert('Kode ICD-10 ini sudah ada dalam daftar');
                }

                // Tutup modal
                $('#modal-kode-icd').modal('hide');
            } else {
                alert('Silakan pilih item terlebih dahulu');
            }
        });

        // Hapus kode ICD X
        icdList.on('click', '.remove-icd', function() {
            const index = $(this).closest('li').data('index');
            icd_10.splice(index, 1);
            displayExistingICD();
        });

        // Reset modal
        $('#btn-kode-icd').on('click', function() {
            $('#modal-kode-icd').modal('show');
            searchInput.val('');
            dataList.empty();
        });

        // Simpan perubahan
        $('#btnSaveChanges').on('click', function() {
            // Kirim data icd_10 ke server dgn AJAX
            $.ajax({
                url: '/update-icd-10', // Ganti dengan URL
                method: 'POST',
                data: {
                    icd_10: JSON.stringify(icd_10)
                },
                success: function(response) {
                    alert('Data ICD-10 berhasil disimpan');
                },
                error: function() {
                    alert('Terjadi kesalahan saat menyimpan data');
                }
            });
        });
    });
</script>
