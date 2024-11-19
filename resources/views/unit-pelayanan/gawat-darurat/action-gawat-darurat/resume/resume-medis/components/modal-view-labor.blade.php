<div class="modal fade" id="modal-view-labor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Hasil Pemeriksaan Laboratorium</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h6 class="fw-bold">Detail Pemeriksaan:</h6>
                    <table class="table table-bordered table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="45%">Nama Pemeriksaan</th>
                                <th width="50%">Hasil</th>
                            </tr>
                        </thead>
                        <tbody id="modal-hasil-content">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $(document).on('click', '.btn-view-labor', function() {
        const hasilLab = $(this).data('hasil-lab');

        $('#modal-hasil-content').empty();

        hasilLab.forEach((item, index) => {
            if (item.hasil_lab) {  // Hanya tampilkan jika ada hasil
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.nama_produk}</td>
                        <td>${item.hasil_lab}</td>
                    </tr>
                `;
                $('#modal-hasil-content').append(row);
            }
        });

        $('#modal-view-labor').modal('show');
    });
});
</script>
