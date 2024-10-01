<!-- Modal Tambah Resep -->
<div class="modal fade" id="tambahResep" tabindex="-1" aria-labelledby="tambahResepLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            <!-- Modal Header -->
           <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tambahResepLabel">Order Obat</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form
                    action="{{ route('farmasi.store', [$dataMedis->pasien->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk))]) }}"
                    method="post">

                    <div class="container-fluid">
                        <div class="row">

                            <!-- Side Column (Kiri) -->
                            <div class="col-md-3 border-right" id="sideColumn">
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs nav-pills nav-fill" id="obatTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active py-1 px-2" id="nonracikan-tab"
                                                    data-bs-toggle="tab" data-bs-target="#nonracikan" type="button"
                                                    role="tab" aria-controls="nonracikan" aria-selected="true">Non
                                                    Racikan</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link py-1 px-2" id="racikan-tab" data-bs-toggle="tab"
                                                    data-bs-target="#racikan" type="button" role="tab"
                                                    aria-controls="racikan" aria-selected="false">Racikan</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link py-1 px-2" id="paket-tab" data-bs-toggle="tab"
                                                    data-bs-target="#paket" type="button" role="tab"
                                                    aria-controls="paket" aria-selected="false">Paket</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link py-1 px-2" id="prognas-tab" data-bs-toggle="tab"
                                                    data-bs-target="#prognas" type="button" role="tab"
                                                    aria-controls="prognas" aria-selected="false">Prognas</button>
                                            </li>
                                        </ul>

                                        <!-- Tab content -->
                                        <div class="tab-content" id="obatTabContent">
                                            <!-- Non Racikan Tab -->
                                            <div class="tab-pane fade show active" id="nonracikan" role="tabpanel"
                                                aria-labelledby="nonracikan-tab">
                                                <div class="mb-3">
                                                    <label for="dokterPengirim" class="form-label">Dokter
                                                        Pengirim</label>
                                                    <select class="form-select" id="dokterPengirim" name="dokter_id">
                                                        <option selected>-Pilih dokter-</option>
                                                        @foreach ($dokters as $dokter)
                                                            <option value="{{ $dokter->id }}">{{ $dokter->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <label for="tanggalOrder" class="form-label">Tanggal
                                                                Order</label>
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
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="cariObat"
                                                            name="nama_obat" placeholder="Ketik nama obat...">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="clearObat" style="display:none;">X</button>
                                                    </div>
                                                    <input type="hidden" id="selectedObatId" name="obat_id">
                                                    <div id="obatList" class="list-group mt-2"></div>
                                                </div>

                                                <!-- Aturan Pakai -->
                                                <div class="mb-3 border p-3">
                                                    <label class="form-label">Aturan Pakai</label>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="jumlahHari" class="form-label">Jumlah
                                                                hari</label>
                                                            <input type="number" class="form-control"
                                                                id="jumlahHari" value="7">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="frekuensi"
                                                                class="form-label">Frekuensi/interval</label>
                                                            <select class="form-select" id="frekuensi">
                                                                <option selected>3 x 1 hari</option>
                                                                <option>2 x 1 hari</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label for="dosis" class="form-label">Dosis</label>
                                                            <select class="form-select" id="dosis">
                                                                <option selected>1/2</option>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="jenisDosis" class="form-label"></label>
                                                            <select class="form-select" id="jenisDosis">
                                                                <option selected>Tablet</option>
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
                                                            <label for="sebelumSesudahMakan"
                                                                class="form-label">Sebelum/Sesudah
                                                                Makan</label>
                                                            <select class="form-select" id="sebelumSesudahMakan">
                                                                <option selected>Sesudah Makan</option>
                                                                <option>Sebelum Makan</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="aturanTambahan" class="form-label">Rute</label>
                                                            <select class="form-select" id="rute">
                                                                <option selected>Oral</option>
                                                                <option>Sunlingual/Buccal</option>
                                                                <option>Prenteral</option>
                                                                <option>Rectal</option>
                                                                <option>Ocular</option>
                                                                <option>Oral Inhalasi</option>
                                                                <option>Vaginal</option>
                                                                <option>Otic/Telinga</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="aturanTambahan" class="form-label">Aturan
                                                                tambahan</label>
                                                            <input type="text" class="form-control"
                                                                id="aturanTambahan" placeholder="Aturan tambahan">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary w-100">Tambah Obat Non Racikan</button>
                                            </div>

                                            <!-- Racikan Tab -->
                                            <div class="tab-pane fade" id="racikan" role="tabpanel"
                                                aria-labelledby="racikan-tab">
                                                <p>Form untuk Racikan akan ditambahkan di sini.</p>
                                            </div>

                                            <!-- Paket Tab -->
                                            <div class="tab-pane fade" id="paket" role="tabpanel"
                                                aria-labelledby="paket-tab">
                                                <p>Form untuk Paket akan ditambahkan di sini.</p>
                                            </div>

                                            <!-- Prognas Tab -->
                                            <div class="tab-pane fade" id="prognas" role="tabpanel"
                                                aria-labelledby="prognas-tab">
                                                <p>Form untuk Prognas akan ditambahkan di sini.</p>
                                            </div>
                                        </div>

                                    </div>
                                </div> 
                            </div>

                            <!-- Main Content Area (Kanan) -->
                            <div class="col-md-9">
                                <!-- Tabs Navigation -->
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab1" type="button" role="tab"
                                            aria-controls="tab1" aria-selected="true">Daftar Order Obat</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab2-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab2" type="button" role="tab"
                                            aria-controls="tab2" aria-selected="false">Riwayat Pemberian Obat</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab3-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab3" type="button" role="tab"
                                            aria-controls="tab3" aria-selected="false">Riwayat Alergi</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab4-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab4" type="button" role="tab"
                                            aria-controls="tab4" aria-selected="false">Antopometri</button>
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
                                            </tbody>
                                        </table>
                                        <div>
                                            <div class="fw-bold">Jumlah Item Obat: 3 </div>
                                            <div class="fw-bold">Total Biaya Obat: Rp. 300.432,-</div>
                                        </div>
                                    </div>

                                    <!-- Tab 2: Riwayat Pemberian Obat -->
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
                                                    <td><button class="btn btn-info btn-sm show-details"
                                                            type="button">X</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Tab 3: Riwayat Alergi -->
                                    <div class="tab-pane fade" id="tab3" role="tabpanel"
                                        aria-labelledby="tab3-tab">
                                        <h4 class="mt-3">Riwayat Alergi</h4>
                                        <p>Informasi riwayat alergi pasien akan ditampilkan di sini.</p>
                                    </div>

                                    <!-- Tab 4: Antopometri -->
                                    <div class="tab-pane fade" id="tab4" role="tabpanel"
                                        aria-labelledby="tab4-tab">
                                        <h4 class="mt-3">Antopometri</h4>
                                        <p>Data antopometri pasien akan ditampilkan di sini.</p>
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
                    <button type="submit" class="btn btn-primary">Order</button>
                </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal Kecil untuk Detail Obat -->
<div class="modal fade" id="detailObatModal" tabindex="-1" aria-labelledby="detailObatModalLabel"
    aria-hidden="true">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const cariObat = $('#cariObat');
            const clearObat = $('#clearObat');
            const obatList = $('#obatList');
            const selectedObatId = $('#selectedObatId');

            var timer;
            cariObat.on('keyup', function() {
                clearTimeout(timer);
                var query = $(this).val();

                timer = setTimeout(function() {
                    if (query.length >= 2) {
                        $.ajax({
                            url: '{{ route('farmasi.searchObat', ['kd_pasien' => $kd_pasien, 'tgl_masuk' => $tgl_masuk]) }}',
                            method: 'GET',
                            data: {
                                term: query
                            },
                            success: function(data) {
                                var html = '';
                                if (data.length > 0) {
                                    data.forEach(function(obat) {
                                        html +=
                                            '<a href="#" class="list-group-item list-group-item-action" data-id="' +
                                            obat.id + '">' + obat.text + '</a>';
                                    });
                                } else {
                                    html =
                                        '<div class="list-group-item text-muted">Tidak ada hasil yang ditemukan</div>';
                                }
                                obatList.html(html);
                            },
                            error: function() {
                                obatList.html(
                                    '<div class="list-group-item text-danger">Terjadi kesalahan saat mencari obat</div>'
                                    );
                            }
                        });
                    } else {
                        obatList.html('');
                    }
                }, 300);
            });

            $(document).on('click', '#obatList a', function(e) {
                e.preventDefault();
                var obatName = $(this).text();
                var obatId = $(this).data('id');
                cariObat.val(obatName).prop('readonly', true);
                selectedObatId.val(obatId);
                obatList.html('');
                clearObat.show();
            });

            clearObat.on('click', function() {
                cariObat.val('').prop('readonly', false);
                selectedObatId.val('');
                clearObat.hide();
            });

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

            document.querySelectorAll('.nav-tabs .nav-link:not(#tab2-tab)').forEach(tab => {
                tab.addEventListener('shown.bs.tab', enableSideColumn);
            });

            // Event listener untuk tombol detail pada tab 2
            document.querySelectorAll('#tab2 .show-details').forEach(button => {
                button.addEventListener('click', function() {
                    // Ambil data dari baris tabel
                    const row = this.closest('tr');
                    const jenis = row.cells[1].textContent;
                    const namaObat = row.cells[2].textContent;
                    const dosis = row.cells[3].textContent;
                    const frek = row.cells[4].textContent;
                    const qty = row.cells[5].textContent;
                    const makan = row.cells[7].textContent;

                    // Isi modal dengan data
                    document.getElementById('detailJenis').textContent = jenis;
                    document.getElementById('detailNama').textContent = namaObat;
                    document.getElementById('detailDosis').textContent = dosis;
                    document.getElementById('detailFrek').textContent = frek;
                    document.getElementById('detailQty').textContent = qty;
                    document.getElementById('detailMakan').textContent = makan;

                    // Tampilkan modal
                    const detailModal = new bootstrap.Modal(document.getElementById(
                        'detailObatModal'));
                    detailModal.show();
                });
            });

            // Menangani perubahan pada select Jenis Obat
            const jenisobatSelect = document.getElementById('jenisobat');
            jenisobatSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                let tabToShow;

                switch (selectedValue) {
                    case '1':
                        tabToShow = document.getElementById('nonracikan-tab');
                        break;
                    case '2':
                        tabToShow = document.getElementById('racikan-tab');
                        break;
                    case '3':
                        tabToShow = document.getElementById('paket-tab');
                        break;
                    case '4':
                        tabToShow = document.getElementById('prognas-tab');
                        break;
                }

                if (tabToShow) {
                    new bootstrap.Tab(tabToShow).show();
                }
            });



        });
    </script>
@endpush
