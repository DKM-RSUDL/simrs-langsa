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
               <form id="resepForm" action="{{ route('farmasi.store', [$dataMedis->pasien->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk))]) }}" method="post">
                    @csrf
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
                                                    <label for="dokterPengirim" class="form-label">Dokter Pengirim</label>
                                                    <select class="form-select" id="dokterPengirim" name="kd_dokter">
                                                        <option value="">-Pilih dokter-</option>
                                                        @foreach ($dokters as $dokter)
                                                            <option value="{{ $dokter->kd_dokter }}">{{ $dokter->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <label for="tanggalOrder" class="form-label">Tanggal Order</label>
                                                            <input type="date" class="form-control" id="tanggalOrder" name="tgl_order">
                                                        </div>
                                                        <div class="col-4">
                                                            <label for="jamOrder" class="form-label">Jam</label>
                                                            <input type="time" class="form-control" id="jamOrder" name="jam_order" value="08:45">
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
                                                                id="jumlahHari">
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
                                                        <div class="col md-4">
                                                            <label for="satuanObat" class="form-label">Satuan
                                                                Obat</label>
                                                            <input type="text" id="satuanObat"
                                                                class="form-control" readonly></input>
                                                            <input type="text" id="hargaObat"
                                                                class="form-control d-none" readonly></input>
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
                                                            <label for="aturanTambahan" class="form-label">Aturan tambahan</label>
                                                                <input type="text" class="form-control" id="aturanTambahan" name="cat_racikan">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" id="tambahObatNonRacikan" class="btn btn-primary w-100">Tambah Obat Non Racikan</button>
                                            </div>

                                            <!-- Racikan Tab -->
                                            <div class="tab-pane fade" id="racikan" role="tabpanel"
                                                aria-labelledby="racikan-tab">
                                                <p>Form untuk Racikan akan ditambahkan di sini.</p>
                                                <button type="button" id="tambahObatRacikan" class="btn btn-primary w-100">Tambah Obat Racikan</button>
                                            </div>

                                            <!-- Paket Tab -->
                                            <div class="tab-pane fade" id="paket" role="tabpanel"
                                                aria-labelledby="paket-tab">
                                                <p>Form untuk Paket akan ditambahkan di sini.</p>
                                                <button type="button" id="tambahObatPaket" class="btn btn-primary w-100">Tambah Obat Paket</button>
                                            </div>

                                            <!-- Prognas Tab -->
                                            <div class="tab-pane fade" id="prognas" role="tabpanel"
                                                aria-labelledby="prognas-tab">
                                                <p>Form untuk Prognas akan ditambahkan di sini.</p>
                                                <button type="button" id="tambahObatPrognas" class="btn btn-primary w-100">Tambah Obat Prognas</button>
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
                                                    <th>Sebelum/Sesudah Makan</th>
                                                    <th>Ket. Tambahan</th>
                                                    <th>Harga</th>
                                                    <th>Pilih</th>
                                                </tr>
                                            </thead>
                                            <tbody id="daftarObatBody"></tbody>
                                        </table>
                                        <div>
                                            <div class="fw-bold">Jumlah Item Obat: 0 </div>
                                            <div class="fw-bold">Total Biaya Obat: Rp. ,-</div>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Order</button>
            </div>
        </form>

        </div>
    </div>
</div>

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Variabel untuk menyimpan daftar obat yang akan diorder
            let daftarObat = [];
            let selectedDokter = null;
            let activeTab = 'Non Racikan';

            $('#obatTabs .nav-link').on('shown.bs.tab', function (e) {
                activeTab = $(e.target).text().trim();
            });

            $('#dokterPengirim').on('change', function() {
                selectedDokter = $(this).val();
                console.log(selectedDokter)
            });

            // Fungsi untuk menambahkan obat ke daftar dan menampilkan di tabel
            $('#tambahObatNonRacikan, #tambahObatRacikan, #tambahObatPaket, #tambahObatPrognas').on('click', function() {
                if (!selectedDokter) {
                    alert("Silakan pilih dokter terlebih dahulu.");
                    return;
                }

                var obatName = $('#cariObat').val();
                var obatId = $('#selectedObatId').val();
                var dosis = $('#dosis').val();
                var frekuensi = $('#frekuensi').val();
                var jumlah = $('#jumlah').val();
                var sebelumSesudahMakan = $('#sebelumSesudahMakan').val();
                var aturanTambahan = $('#aturanTambahan').val();
                var satuanObat = $('#satuanObat').val();
                var hargaObat = $('#hargaObat').val();

                if (!obatId) {
                    alert("Pilih obat terlebih dahulu.");
                    return;
                }

                // Cek jika obat sudah ada dalam daftar
                const exists = daftarObat.some(obat => obat.id === obatId);
                if (exists) {
                    alert("Obat sudah ada dalam daftar.");
                    return;
                }

                // Simpan ke daftar obat
                daftarObat.push({
                    id: obatId,
                    nama: obatName,
                    dosis: dosis,
                    frekuensi: frekuensi,
                    jumlah: jumlah,
                    sebelumSesudahMakan: sebelumSesudahMakan,
                    aturanTambahan: aturanTambahan,
                    harga: hargaObat,
                    satuan: satuanObat,
                    jenisObat: activeTab,
                    kd_dokter: selectedDokter
                });

                // Tampilkan di tabel sebelah kanan
                renderDaftarObat();

                // Reset form input obat setelah ditambahkan
                $('#cariObat').val('').prop('readonly', false);
                $('#selectedObatId').val('');
                $('#jumlah').val('');
                $('#aturanTambahan').val('');
                $('#satuanObat').val('');
                $('#clearObat').hide();
            });


            //-----------Fungsi untuk Untuk Input Ke Database---------- //
            $('#resepForm').on('submit', function(e) {
                e.preventDefault();

                // Validasi form sebelum mengirim
                if (!$('#dokterPengirim').val()) {
                    alert('Silakan pilih dokter pengirim.');
                    return;
                }

                if (daftarObat.length === 0) {
                    alert('Silakan tambahkan minimal satu obat sebelum mengirim resep.');
                    return;
                }

                var formData = {
                    kd_dokter: selectedDokter,
                    tgl_order: $('#tanggalOrder').val() + ' ' + $('#jamOrder').val(),
                    cat_racikan: $('#aturanTambahan').val(),
                    obat: daftarObat.map(obat => ({
                        id: obat.id,
                        frekuensi: obat.frekuensi,
                        jumlah: obat.jumlah,
                        dosis: obat.dosis,
                        sebelumSesudahMakan: obat.sebelumSesudahMakan,
                        aturanTambahan: obat.aturanTambahan
                    }))
                };

                console.log('Sending data:', formData);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.id_mrresep) {
                            alert('Resep berhasil disimpan dengan ID: ' + response.id_mrresep);
                            daftarObat = [];
                            renderDaftarObat();
                            $('#resepForm')[0].reset();
                            $('#dokterPengirim').prop('disabled', false);
                            selectedDokter = null;
                        } else {
                            alert('Resep berhasil disimpan, tetapi ID tidak diterima.');
                        }
                    },
                    
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            // Error validasi
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = 'Validasi gagal:\n';
                            for (let field in errors) {
                                errorMessage += `${field}: ${errors[field].join(', ')}\n`;
                            }
                            alert(errorMessage);
                        } else {
                            // Error lainnya
                           alert('Terjadi kesalahan: ' + (xhr.responseJSON ? xhr.responseJSON.message : error));
                        }
                    }
                });
            });
            //-----------END Fungsi untuk Untuk Input Ke Database---------- //


            // Fungsi untuk menampilkan daftar obat di tabel
            var obatSelect;
            function renderDaftarObat() {
                var tbody = $('#daftarObatBody');
                tbody.empty();

                let totalBiaya = 0;

                daftarObat.forEach(function(obat, index) {
                    let subtotal = obat.harga * obat.jumlah;
                    totalBiaya += subtotal;

                    tbody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${obat.jenisObat}</td>
                            <td>${obat.nama}</td>
                            <td>${obat.dosis} ${obat.satuan}</td>
                            <td>${obat.frekuensi}</td>
                            <td>${obat.jumlah}</td>
                            <td>${obat.sebelumSesudahMakan}</td>
                            <td>${obat.aturanTambahan || '-'}</td>
                            <td>Rp. ${subtotal.toLocaleString()}</td>
                            <td><button class="btn btn-danger btn-sm" onclick="removeObat(${index})">X</button></td>
                        </tr>
                    `);
                });

                // Tampilkan total item dan biaya
                $('.fw-bold:contains("Jumlah Item Obat")').text(`Jumlah Item Obat: ${daftarObat.length}`);
                $('.fw-bold:contains("Total Biaya Obat")').text(
                    `Total Biaya Obat: Rp. ${totalBiaya.toLocaleString()}`);
            }

            // Fungsi untuk menghapus obat dari daftar
            window.removeObat = function(index) {
                daftarObat.splice(index, 1);
                renderDaftarObat();
            };


            //-------------Fungsi untuk menampilkan obat------------ //
            const cariObat = $('#cariObat');
            const clearObat = $('#clearObat');
            const obatList = $('#obatList');
            const selectedObatId = $('#selectedObatId');
            const satuanObat = $('#satuanObat');
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
                                            '<a href="#" class="list-group-item list-group-item-action" ' +
                                            'data-id="' + obat.id + '" ' +
                                            'data-harga="' + obat.harga + '" ' + // Pastikan harga dimasukkan ke data-harga
                                            'data-satuan="' + obat.satuan + '">' +
                                            obat.text + '</a>';
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
                var $this = $(this);
                var obatName = $(this).text();
                var obatId = $(this).data('id');
                var obatSatuan = $(this).data('satuan');
                var obatHarga = $this.attr('data-harga');


                cariObat.val(obatName).prop('readonly', true);
                selectedObatId.val(obatId);
                $('#satuanObat').val(obatSatuan);
                $('#hargaObat').val(obatHarga);
                obatList.html('');
                clearObat.show();
            });

            clearObat.on('click', function() {
                cariObat.val('').prop('readonly', false);
                selectedObatId.val('');
                $('#satuanObat').val('');
                clearObat.hide();
            });
            //------------- End Fungsi untuk menampilkan obat---------- //


            //----------- Fungsi untuk menonaktifkan side column -------------//
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
            //----------- End Fungsi untuk menonaktifkan side column---------- //

            function formatDateTime(date, time) {
                return `${date}T${time}:00`;
            }

        });
    </script>
@endpush
