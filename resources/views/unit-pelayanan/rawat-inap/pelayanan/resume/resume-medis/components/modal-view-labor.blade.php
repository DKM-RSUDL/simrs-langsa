<div class="modal fade" id="modal-view-labor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    Hasil Pemeriksaan Laboratorium
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">
                        Pemeriksaan No. <span id="nomor-pemeriksaan-view"></span>:
                        <span id="nama-pemeriksaan-view"></span>
                        <span id="nama-klasifikasi-view"></span>
                    </h6>
                </div>
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Item Test</th>
                            <th>Hasil</th>
                            <th>Satuan</th>
                            <th>Nilai Normal</th>
                        </tr>
                    </thead>
                    <tbody id="modal-hasil-labor-view">
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
    $(document).ready(function() {
        $(document).on('click', '.btn-view-labor', function() {
            const kdOrder = $(this).data('kd-order');
            const namaPemeriksaan = $(this).data('nama-pemeriksaan');
            const klasifikasi = $(this).data('klasifikasi');
            const nomorPemeriksaan = $(this).data('nomor');

            $('#nomor-pemeriksaan-view').text(nomorPemeriksaan);
            $('#nama-pemeriksaan-view').text(namaPemeriksaan);
            $('#nama-klasifikasi-view').text(` (${klasifikasi})`);

            $('#modal-hasil-labor-view').empty();

            // Ambil data yang sudah di-transform di controller
            const labResults = {!! json_encode($dataLabor) !!};
            const orderData = labResults.find(order => order.kd_order === kdOrder);

            if (orderData && orderData.details) {
                const detail = orderData.details.find(d =>
                    (d.produk?.deskripsi ?? 'Pemeriksaan') === namaPemeriksaan
                );

                if (detail && detail.labResults && detail.labResults[namaPemeriksaan]) {
                    const results = detail.labResults[namaPemeriksaan];
                    let counter = 1;

                    // Header klasifikasi
                    $('#modal-hasil-labor-view').append(`
                        <tr class="table-secondary">
                            <td colspan="5" class="fw-bold">${klasifikasi}</td>
                        </tr>
                    `);

                    // Tampilkan hasil tests
                    results.tests.forEach(test => {
                        const row = `
                            <tr>
                                <td>${counter++}</td>
                                <td>${test.item_test || '-'}</td>
                                <td>${test.hasil || '-'}</td>
                                <td>${test.satuan || '-'}</td>
                                <td>${test.nilai_normal || '-'}</td>
                            </tr>
                        `;
                        $('#modal-hasil-labor-view').append(row);
                    });

                    if (counter === 1) {
                        $('#modal-hasil-labor-view').append(`
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada hasil pemeriksaan detail untuk ${namaPemeriksaan}</td>
                            </tr>
                        `);
                    }
                } else {
                    $('#modal-hasil-labor-view').append(`
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data hasil laboratorium</td>
                        </tr>
                    `);
                }
            } else {
                $('#modal-hasil-labor-view').append(`
                    <tr>
                        <td colspan="5" class="text-center">Data tidak ditemukan</td>
                    </tr>
                `);
            }

            // Tampilkan modal
            $('#modal-view-labor').modal('show');
        });
    });
</script>
