<!-- Modal Tambah Resep -->
<div class="modal fade" id="tambahResep" tabindex="-1" aria-labelledby="tambahResepLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahResepLabel">Order Obat</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Side Column (Kiri) -->
                        <div class="col-md-3 border-right" id="sideColumn">
                            <!-- Card untuk Input Obat Resep -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="jenisobat" class="form-label">Jenis Obat</label>
                                        <select class="form-select" id="jenisobat">
                                            <option value="1">Non Racikan</option>
                                            <option value="2">Racikan</option>
                                            <option value="3">Paket</option>
                                            <option value="4">Prognas</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dokterPengirim" class="form-label">Dokter Pengirim</label>
                                        <select class="form-select" id="dokterPengirim">
                                            <option selected>-Pilih dokter-</option>
                                            <option value="1">Dr. A</option>
                                            <option value="2">Dr. B</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <label for="tanggalOrder" class="form-label">Tanggal Order</label>
                                                <input type="date" class="form-control" id="tanggalOrder"
                                                    value="2025-01-31">
                                            </div>
                                            <div class="col-4">
                                                <label for="jamOrder" class="form-label">Jam</label>
                                                <input type="time" class="form-control" id="jamOrder"
                                                    value="08:45">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cariObat" class="form-label">Cari Nama Obat</label>
                                        <input type="text" class="form-control" id="cariObat"
                                            placeholder="Cari obat">
                                    </div>
                                    <!-- Aturan Pakai -->
                                    <div class="mb-3 border p-3">
                                        <label class="form-label">Aturan Pakai</label>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="jumlahHari" class="form-label">Jumlah hari</label>
                                                <input type="number" class="form-control" id="jumlahHari"
                                                    value="7">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="frekuensi" class="form-label">Frekuensi/interval</label>
                                                <select class="form-select" id="frekuensi">
                                                    <option selected>3 x 1 hari</option>
                                                    <option>2 x 1 hari</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="dosis" class="form-label">Dosis</label>
                                                <input type="text" class="form-control" id="dosis"
                                                    value="1/2">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="jenisDosis" class="form-label">Jenis Dosis</label>
                                                <select class="form-select" id="jenisDosis">
                                                    <option selected>Tablet</option>
                                                    <option>Kapsul</option>
                                                    <option>Syrup</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="jumlah" class="form-label">Jumlah</label>
                                                <input type="number" class="form-control" id="jumlah"
                                                    value="12">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="sebelumSesudahMakan" class="form-label">Sebelum/Sesudah
                                                    Makan</label>
                                                <select class="form-select" id="sebelumSesudahMakan">
                                                    <option selected>Sesudah Makan</option>
                                                    <option>Sebelum Makan</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="aturanTambahan" class="form-label">Aturan tambahan</label>
                                                <input type="text" class="form-control" id="aturanTambahan"
                                                    placeholder="Aturan tambahan">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Aturan Pakai -->

                                    <button class="btn btn-primary w-100">Tambah Obat</button>
                                </div>
                            </div> <!-- End of Card -->
                        </div>

                        <!-- Main Content Area (Kanan) -->
                        <div class="col-md-9">
                            <!-- Tabs Navigation -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1"
                                        aria-selected="true">Daftar Order Obat</button>
                                </li>
                                 <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab2-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2"
                                        aria-selected="false">Riwayat Pemberian Obat</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab3-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3"
                                        aria-selected="false">Riwayat Alergi</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab4-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab4" type="button" role="tab" aria-controls="tab4"
                                        aria-selected="false">Antopometri</button>
                                </li>
                            </ul>

                            <!-- Tabs Content -->
                            <div class="tab-content" id="myTabContent">
                                <!-- Tab 1: Daftar Obat -->
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                    aria-labelledby="tab1-tab">
                                    <table class="table table-bordered mt-3">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis Obat</th>
                                                <th>Nama Obat</th>
                                                <th>Dosis</th>
                                                <th>Frek</th>
                                                <th>Qty</th>
                                                <th>Rute</th>
                                                <th>Sebelum/Sesudah Makan</th>
                                                <th>Ket. Tambahan</th>
                                                <th>Harga</th>
                                                <th>Pilih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Non Racik</td>
                                                <td>PARACETAMOL 500 mg (tab)</td>
                                                <td>1/2 tablet</td>
                                                <td>3 x 1 hari</td>
                                                <td>21</td>
                                                <td>Oral</td>
                                                <td>Sesudah makan (pagi, siang, malam)</td>
                                                <td>-</td>
                                                <td>Rp. 23.000</td>
                                                <td><button class="btn btn-danger btn-sm">X</button></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Non Racik</td>
                                                <td>OBH (Syrup)</td>
                                                <td>1/2 sdm</td>
                                                <td>3 x 1 hari</td>
                                                <td>1</td>
                                                <td>Oral</td>
                                                <td>Sesudah makan</td>
                                                <td>-</td>
                                                <td>Rp. 10.000</td>
                                                <td><button class="btn btn-danger btn-sm">X</button></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Non Racik</td>
                                                <td>ASAM MEFENAMAT 5mg (tab)</td>
                                                <td>1 tablet</td>
                                                <td>3 x 1 hari</td>
                                                <td>21</td>
                                                <td>Oral</td>
                                                <td>Sesudah makan</td>
                                                <td>-</td>
                                                <td>Rp. 13.000</td>
                                                <td><button class="btn btn-danger btn-sm">X</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div>
                                        <div class="fw-bold">Jumlah Item Obat: 3 </div>
                                        <div class="fw-bold">Total Biaya Obat: Rp. 300.432,-</div>
                                    </div>
                                </div>

                                <!-- Tab 2: Riwayat Alergi -->
                                <div class="tab-pane fade" id="tab2" role="tabpanel"
                                    aria-labelledby="tab2-tab">
                                    <table class="table table-bordered mt-3">
                                        <thead>
                                            <tr>
                                                <th>No Order</th>
                                                <th>Jenis Obat</th>
                                                <th>Nama Obat</th>
                                                <th>Dosis</th>
                                                <th>Frek</th>
                                                <th>Qty</th>
                                                <th>Rute</th>
                                                <th>Sebelum/Sesudah Makan</th>
                                                <th>Ket. Tambahan</th>
                                                <th>Dokter</th>
                                                <th>Pilih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>000973</td>
                                                <td>Non Racik</td>
                                                <td>PARACETAMOL 500 mg (tab)</td>
                                                <td>1/2 tablet</td>
                                                <td>3 x 1 hari</td>
                                                <td>21</td>
                                                <td>Oral</td>
                                                <td>Sesudah makan (pagi, siang, malam)</td>
                                                <td>-</td>
                                                <td>Dokter A</td>
                                                <td><button class="btn btn-info btn-sm show-details">X</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Tab 3: Info Tambahan -->
                                <div class="tab-pane fade" id="tab3" role="tabpanel"
                                    aria-labelledby="tab3-tab">
                                    <h4 class="mt-3">Tabs 3</h4>
                                    <p>Area ini bisa digunakan untuk menampilkan informasi tambahan atau instruksi lebih
                                        lanjut terkait pemesanan obat.</p>
                                </div>

                                <!-- Tab 4: Info Tambahan -->
                                <div class="tab-pane fade" id="tab4" role="tabpanel"
                                    aria-labelledby="tab4-tab">
                                    <h4 class="mt-3">Tabs 4</h4>
                                    <p>Area ini bisa digunakan untuk menampilkan informasi tambahan atau instruksi lebih
                                        lanjut terkait pemesanan obat.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah dan Total di Footer -->
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Order</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kecil untuk Detail Obat -->
<div class="modal fade" id="detailObatModal" tabindex="-1" aria-labelledby="detailObatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailObatModalLabel">Detail Pemberian Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Isi dengan detail obat -->
                <p><strong>Jenis:</strong> <span id="detailJenis"></span></p>
                <p><strong>Nama Obat:</strong> <span id="detailNama"></span></p>
                <p><strong>Dosis:</strong> <span id="detailDosis"></span></p>
                <p><strong>Frek:</strong> <span id="detailFrek"></span></p>
                <p><strong>Qty:</strong> <span id="detailQty"></span></p>
                <p><strong>Sebelum/Sesudah Makan:</strong> <span id="detailMakan"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Copy Obat</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const tab2 = document.getElementById('tab2-tab');
    const sideColumn = document.getElementById('sideColumn');

    function disableSideColumn() {
        sideColumn.style.pointerEvents = 'none';
        sideColumn.style.opacity = '0.5';
        sideColumn.style.backgroundColor = '#f0f0f0';
    }

    function enableSideColumn() {
        sideColumn.style.pointerEvents = 'auto';
        sideColumn.style.opacity = '1';
        sideColumn.style.backgroundColor = '';
    }

    tab2.addEventListener('shown.bs.tab', disableSideColumn);

    document.querySelectorAll('.nav-link:not(#tab2-tab)').forEach(tab => {
        tab.addEventListener('shown.bs.tab', enableSideColumn);
    });

    // Event listener untuk tombol detail pada tab 2
    document.querySelectorAll('#tab2 .show-details').forEach(button => {
        button.addEventListener('click', function() {
            // Ambil data dari baris tabel
            const row = this.closest('tr');
            const namaJenis = row.cells[1].textContent;
            const namaObat = row.cells[2].textContent;
            const dosis = row.cells[3].textContent;
            const frek = row.cells[4].textContent;
            const qty = row.cells[5].textContent;
            const makan = row.cells[6].textContent;

            // Isi modal dengan data
            document.getElementById('detailJenis').textContent = namaJenis;
            document.getElementById('detailNama').textContent = namaObat;
            document.getElementById('detailDosis').textContent = dosis;
            document.getElementById('detailFrek').textContent = frek;
            document.getElementById('detailQty').textContent = qty;
            document.getElementById('detailMakan').textContent = makan;

            // Tampilkan modal
            const detailModal = new bootstrap.Modal(document.getElementById('detailObatModal'));
            detailModal.show();
        });
    });

});

</script>
@endpush