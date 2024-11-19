<!-- Modal Hasil Labor -->
<div class="modal fade" id="modal-view-labor-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Hasil Pemeriksaan Laboratorium</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">Daftar Order Pemeriksaan:</h6>
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemeriksaan</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                    <tbody id="modal-hasil-content">
                        <!-- Data akan diisi melalui JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.btn-view-labor-create', function() {
        const details = $(this).data('details');
        console.log(details);

        // Kosongkan tbody modal
        $('#modal-hasil-content').empty();

        // Isi data ke dalam modal
        if (details && details.length > 0) {
            details.forEach((detail, index) => {
                const labHasil = detail.produk ? detail.produk.lab_hasil : [];
                labHasil.forEach((hasil, hasilIndex) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${detail.produk ? detail.produk.deskripsi : 'Tidak ada deskripsi'}</td>
                            <td>${hasil ? hasil.hasil : '-'}</td>
                        </tr>
                    `;
                    $('#modal-hasil-content').append(row);
                });
            });
        } else {
            $('#modal-hasil-content').append(`
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data hasil laboratorium</td>
                </tr>
            `);
        }

        // Tampilkan modal
        $('#modal-view-labor-create').modal('show');
    });
</script>

