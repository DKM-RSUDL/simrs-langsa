@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .modal-overlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1050;
        }

        #editObatModal {
            z-index: 1060;
        }

        #searchObatSpinner {
            display: none;
            margin-left: 10px;
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="container-fluid">
                <form id="resepForm"
                    action="{{ route('rawat-inap.farmasi.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="POST">
                    @csrf
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
                                                data-bs-target="#paket" type="button" role="tab" aria-controls="paket"
                                                aria-selected="false">Paket</button>
                                        </li>
                                    </ul>

                                    <!-- Tab content -->
                                    <div class="tab-content" id="obatTabContent">
                                        <!-- Non Racikan Tab -->
                                        <div class="tab-pane fade show active" id="nonracikan" role="tabpanel"
                                            aria-labelledby="nonracikan-tab">
                                            <div class="mb-3">
                                                <label for="dokterPengirim" class="form-label">Dokter Pengirim</label>
                                                <select class="form-select" id="dokterPengirim"
                                                    @cannot('is-admin') disabled @endcannot>
                                                    @foreach ($dokters as $dokter)
                                                        <option value="{{ $dokter->kd_dokter }}"
                                                            @selected($dokter->kd_karyawan == auth()->user()->kd_karyawan)>
                                                            {{ $dokter->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="mb-3">
                                                <label for="tanggalOrder" class="form-label">Tanggal dan Jam Order</label>
                                                <input type="datetime-local" class="form-control" id="tanggalOrder"
                                                    name="tgl_order"
                                                    value="{{ old('tgl_order', now()->format('Y-m-d\TH:i')) }}" required>
                                                @error('tgl_order')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Aturan Pakai -->
                                            <div class="mb-3 border p-3">
                                                <div class="mb-3">
                                                    <label for="cariObat" class="form-label">Cari Nama Obat</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="cariObat"
                                                            name="nama_obat" placeholder="Ketik nama obat...">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="clearObat" style="display:none;">X</button>
                                                        <span id="searchObatSpinner"
                                                            class="spinner-border spinner-border-sm" role="status"
                                                            aria-hidden="true"></span>
                                                    </div>
                                                    <input type="hidden" id="selectedObatId" name="obat_id">
                                                    <div id="obatList" class="list-group mt-2"></div>
                                                </div>
                                                <label class="form-label">Aturan Pakai</label>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label for="frekuensi"
                                                            class="form-label">Frekuensi/interval</label>
                                                        <input type="text" id="frekuensi" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="dosis" class="form-label">Dosis Sekali</label>
                                                        <input type="text" id="dosis" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="satuanObat" class="form-label">Satuan Obat</label>
                                                        <input type="text" id="satuanObat" class="form-control">
                                                        <input type="text" id="hargaObat" class="form-control d-none"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label for="jumlah" class="form-label">Jumlah Obat</label>
                                                        <input type="number" class="form-control" id="jumlah">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label for="sebelumSesudahMakan"
                                                            class="form-label">Sebelum/Sesudah Makan</label>
                                                        <select class="form-select" id="sebelumSesudahMakan">
                                                            <option selected>Sesudah Makan</option>
                                                            <option>Sebelum Makan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label for="aturanTambahan" class="form-label">Aturan
                                                            tambahan</label>
                                                        <textarea class="form-control" id="aturanTambahan">{{ old('aturanTambahan') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" id="tambahObatNonRacikan"
                                                class="btn btn-primary w-100">Tambah Obat Non Racikan</button>
                                        </div>

                                        <!-- Racikan Tab -->
                                        <div class="tab-pane fade" id="racikan" role="tabpanel"
                                            aria-labelledby="racikan-tab">
                                            <p class="text-danger">Form untuk Racikan Belum Tersedia!</p>
                                        </div>

                                        <!-- Paket Tab -->
                                        <div class="tab-pane fade" id="paket" role="tabpanel"
                                            aria-labelledby="paket-tab">
                                            <p class="text-danger">Form untuk Paket Belum Tersedia!</p>
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
                                        data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1"
                                        aria-selected="true">Daftar Order Obat</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2"
                                        type="button" role="tab" aria-controls="tab2" aria-selected="false">Riwayat
                                        Pemberian Obat</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3"
                                        type="button" role="tab" aria-controls="tab3" aria-selected="false">Riwayat
                                        Alergi</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab4-tab" data-bs-toggle="tab" data-bs-target="#tab4"
                                        type="button" role="tab" aria-controls="tab4"
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

                                    <div class="mt-4">
                                        <h5>Catatan Resep (Opsional)</h5>
                                        <div class="form-group">
                                            <textarea class="form-control" id="cat_racikan" name="cat_racikan" rows="3"
                                                placeholder="Masukkan catatan tambahan untuk resep ini...">{{ old('cat_racikan') }}</textarea>
                                        </div>
                                    </div>
                                    <!-- Hidden inputs for obat data -->
                                    <div id="obatInputs"></div>
                                </div>

                                <!-- Tab 2: Riwayat Pemberian Obat -->
                                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
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
                                            @forelse ($riwayatObat as $resep)
                                                @php
                                                    $cara_pakai_parts = explode(',', $resep->cara_pakai);
                                                    $frekuensi = trim($cara_pakai_parts[0] ?? '');
                                                    $keterangan = trim($cara_pakai_parts[1] ?? '');
                                                @endphp
                                                <tr>
                                                    <td>{{ (int) $resep->id_mrresep }}</td>
                                                    <td>Jenis Obat</td>
                                                    <td>{{ $resep->nama_obat ?? 'Tidak ada informasi' }}</td>
                                                    <td>{{ $resep->jumlah_takaran }}
                                                        {{ Str::title($resep->satuan_takaran) }}</td>
                                                    <td>{{ $frekuensi }}</td>
                                                    <td>{{ (int) $resep->jumlah ?? 'Tidak ada informasi' }}</td>
                                                    <td>Rute</td>
                                                    <td>{{ $keterangan }}</td>
                                                    <td>{{ $resep->ket }}</td>
                                                    <td>{{ $resep->nama_dokter }}</td>
                                                    <td>
                                                        @include('unit-pelayanan.rawat-inap.pelayanan.farmasi.copyobat')
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="11" class="text-center">Tidak ada data resep
                                                        obat.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Tab 3: Riwayat Alergi -->
                                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                    <h4 class="mt-3">Riwayat Alergi</h4>
                                    <p>Informasi riwayat alergi pasien akan ditampilkan di sini.</p>
                                </div>

                                <!-- Tab 4: Antopometri -->
                                <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                                    <h4 class="mt-3">Antopometri</h4>
                                    <p>Data antopometri pasien akan ditampilkan di sini.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer with Buttons -->
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('rawat-inap.farmasi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                            class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" id="orderButton" class="btn btn-primary">Order</button>
                        <div id="loadingIndicator" class="spinner-border text-primary me-3 d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(function() {
            // ------------ 1. Variabel Global dan Inisialisasi ------------ //
            let daftarObat = [];
            let activeTab = 'Non Racikan';
            let selectedDokter;

            const dokterSelect = $('#dokterPengirim');

            @php
                $dokterLoggedIn = null;
                foreach ($dokters as $dokter) {
                    if ($dokter->kd_karyawan == auth()->user()->kd_karyawan) {
                        $dokterLoggedIn = $dokter;
                        break;
                    }
                }
            @endphp

            // Set nilai default untuk selectedDokter dari dokter yang login
            selectedDokter = "{{ $dokterLoggedIn ? $dokterLoggedIn->kd_dokter : '' }}";

            // Atur dokter pengirim berdasarkan peran
            @can('is-admin')
                // Enable the select field for admins
                dokterSelect
                    .prop('disabled', false)
                    .css({
                        'pointer-events': 'auto',
                        'background-color': '#ffffff',
                        'cursor': 'pointer'
                    })
                    .removeAttr('tabindex');

                // Update selectedDokter when admin changes the selection
                dokterSelect.on('change', function() {
                    selectedDokter = $(this).val();
                    console.log("Dokter dipilih (admin): ", selectedDokter);
                    updateObatInputs(); // Update semua input hidden saat dokter berubah
                });
            @else
                // Keep disabled state for non-admin users
                dokterSelect
                    .prop('disabled', true)
                    .css({
                        'pointer-events': 'none',
                        'background-color': '#e9ecef',
                        'cursor': 'not-allowed'
                    })
                    .attr('tabindex', '-1');

                // Pastikan selectedDokter tetap diisi untuk non-admin (dokter)
                console.log("Dokter yang login: ", selectedDokter);
            @endcan

            // ------------ 2. Event Listener untuk Tab dan Obat ------------ //
            $('#obatTabs .nav-link').on('shown.bs.tab', function(e) {
                activeTab = $(e.target).text().trim();
            });

            // Fungsi untuk menambahkan obat ke daftar dan menampilkan di tabel
            $('#tambahObatNonRacikan').on('click', function() {
                var obatName = $('#cariObat').val();
                var obatId = $('#selectedObatId').val();
                var dosis = $('#dosis').val();
                var frekuensi = $('#frekuensi').val();
                var jumlah = $('#jumlah').val();
                var sebelumSesudahMakan = $('#sebelumSesudahMakan').val();
                var aturanTambahan = $('#aturanTambahan').val();
                var satuanObat = $('#satuanObat').val();
                var hargaObat = parseFloat($('#hargaObat').val()) || 0;

                if (!obatId) {
                    iziToast.error({
                        title: 'Error',
                        message: "Pilih obat terlebih dahulu.",
                        position: 'topRight'
                    });
                    return;
                }

                if (!jumlah || isNaN(jumlah) || jumlah < 1) {
                    iziToast.error({
                        title: 'Error',
                        message: "Masukkan jumlah obat yang valid.",
                        position: 'topRight'
                    });
                    return;
                }

                // Cek jika obat sudah ada dalam daftar
                const exists = daftarObat.some(obat => obat.id === obatId);
                if (exists) {
                    iziToast.warning({
                        title: 'Perhatian',
                        message: "Obat sudah ada dalam daftar.",
                        position: 'topRight'
                    });
                    return;
                }

                // Tambah ke daftar obat
                daftarObat.push({
                    id: obatId,
                    nama: obatName,
                    dosis: dosis,
                    frekuensi: frekuensi,
                    jumlah: parseInt(jumlah),
                    sebelumSesudahMakan: sebelumSesudahMakan,
                    aturanTambahan: aturanTambahan,
                    harga: hargaObat,
                    satuan: satuanObat,
                    jenisObat: activeTab,
                    kd_dokter: selectedDokter
                });

                renderDaftarObat();
                updateObatInputs(); // Update input hidden saat menambah obat
                resetInputObat();
            });

            // Fungsi Copy Obat
            $(document).on('click', '.copy-obat', function() {
                var obatData = $(this).data('obat');
                $('#modal-overlay').show();

                var editModal = new bootstrap.Modal($('#editObatModal'));
                editModal.show();

                $('#editObatModal').css({
                    'position': 'absolute',
                    'top': '50%',
                    'left': '50%',
                    'transform': 'translate(-50%, -50%)'
                });

                openEditModal(obatData);
            });

            $('#editObatModal').on('hidden.bs.modal', function() {
                $('#modal-overlay').hide();
            });

            function openEditModal(obatData) {
                var caraPakai = obatData.cara_pakai ? obatData.cara_pakai.split(',') : [];
                var frekuensi = caraPakai[0] ? caraPakai[0].trim() : 'N/A';
                var sebelumSesudahMakan = caraPakai[1] ? caraPakai[1].trim() : 'N/A';

                $('#editNamaObat').val(obatData.nama_obat || 'Tidak ada informasi');
                $('#editFrekuensi').val(frekuensi || '');
                $('#editDosis').val(obatData.jumlah_takaran || '');
                $('#editSatuanObat').val(obatData.satuan_takaran || '');
                $('#editJumlah').val(parseInt(obatData.jumlah) || 1);
                $('#editSebelumSesudahMakan').val(sebelumSesudahMakan || 'Sesudah Makan');
                $('#editKeterangan').val(obatData.ket || '');

                $('#saveEditObat').off('click');
                $('#saveEditObat').on('click', function() {
                    saveEditedObat(obatData);
                });
            }

            function saveEditedObat(originalObatData) {
                var editedData = {
                    id: originalObatData.kd_prd,
                    nama: originalObatData.nama_obat || 'Tidak ada informasi',
                    frekuensi: $('#editFrekuensi').val(),
                    dosis: $('#editDosis').val(),
                    satuan: $('#editSatuanObat').val(),
                    jumlah: parseInt($('#editJumlah').val()),
                    sebelumSesudahMakan: $('#editSebelumSesudahMakan').val(),
                    aturanTambahan: $('#editKeterangan').val(),
                    harga: parseFloat(originalObatData.harga) || 0,
                    jenisObat: 'Non Racikan',
                    kd_dokter: selectedDokter
                };

                const existingIndex = daftarObat.findIndex(obat => obat.id === editedData.id);
                if (existingIndex !== -1) {
                    daftarObat[existingIndex] = editedData;
                    iziToast.info({
                        title: 'Info',
                        message: 'Obat sudah ada dalam daftar dan telah diperbarui.',
                        position: 'topRight'
                    });
                } else {
                    daftarObat.push(editedData);
                    iziToast.success({
                        title: 'Sukses',
                        message: 'Obat berhasil ditambahkan ke daftar.',
                        position: 'topRight'
                    });
                }
                renderDaftarObat();
                updateObatInputs(); // Update input hidden saat mengedit obat
                $('#editObatModal').modal('hide');
                $('#modal-overlay').hide();
            }

            // ------------ 3. Fungsi CRUD Obat (Render, Hapus) ------------ //
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

                $('.fw-bold:contains("Jumlah Item Obat")').text(`Jumlah Item Obat: ${daftarObat.length}`);
                $('.fw-bold:contains("Total Biaya Obat")').text(
                    `Total Biaya Obat: Rp. ${totalBiaya.toLocaleString()}`);
            }

            window.removeObat = function(index) {
                daftarObat.splice(index, 1);
                renderDaftarObat();
                updateObatInputs(); // Update input hidden saat menghapus obat
            };

            // Fungsi untuk memperbarui input hidden obat
            function updateObatInputs() {
                var obatInputs = $('#obatInputs');
                obatInputs.empty();

                // Tambahkan input hidden untuk kd_dokter
                obatInputs.append(`<input type="hidden" name="kd_dokter" value="${selectedDokter}">`);

                daftarObat.forEach(function(obat, index) {
                    obatInputs.append(`
                        <input type="hidden" name="obat[${index}][id]" value="${obat.id}">
                        <input type="hidden" name="obat[${index}][frekuensi]" value="${obat.frekuensi}">
                        <input type="hidden" name="obat[${index}][jumlah]" value="${obat.jumlah}">
                        <input type="hidden" name="obat[${index}][dosis]" value="${obat.dosis}">
                        <input type="hidden" name="obat[${index}][sebelumSesudahMakan]" value="${obat.sebelumSesudahMakan}">
                        <input type="hidden" name="obat[${index}][aturanTambahan]" value="${obat.aturanTambahan || ''}">
                        <input type="hidden" name="obat[${index}][satuan]" value="${obat.satuan}">
                    `);
                });
            }

            // Validasi sisi klien sebelum submit
            $('#resepForm').on('submit', function(e) {
                if (daftarObat.length === 0) {
                    e.preventDefault();
                    iziToast.error({
                        title: 'Error',
                        message: 'Silakan tambahkan minimal satu obat sebelum mengirim resep.',
                        position: 'topRight'
                    });
                    return false;
                }

                var tanggalOrder = $('#tanggalOrder').val();

                if (!tanggalOrder) {
                    e.preventDefault();
                    iziToast.error({
                        title: 'Error',
                        message: 'Tanggal dan jam order harus diisi.',
                        position: 'topRight'
                    });
                    return false;
                }

                // Validasi kd_dokter
                if (!selectedDokter || selectedDokter.length > 3) {
                    e.preventDefault();
                    iziToast.error({
                        title: 'Error',
                        message: 'Silahkan Pilih Dokter Terlebih dahulu!.',
                        position: 'topRight'
                    });
                    return false;
                }

                $('#loadingIndicator').removeClass('d-none');
                $('#orderButton').prop('disabled', true);

                // Form akan melakukan submit normal ke server
            });

            // ------------ 5. Fungsi Pencarian Obat ------------ //
            const cariObat = $('#cariObat');
            const clearObat = $('#clearObat');
            const obatList = $('#obatList');
            const selectedObatId = $('#selectedObatId');
            const satuanObat = $('#satuanObat');
            const searchObatSpinner = $('#searchObatSpinner');
            var timer;

            cariObat.on('keyup', function() {
                clearTimeout(timer);
                var query = $(this).val();

                timer = setTimeout(function() {
                    if (query.length >= 2) {
                        searchObatSpinner.show();
                        $.ajax({
                            url: '{{ route('farmasi.searchObat', ['kd_pasien' => $kd_pasien, 'tgl_masuk' => $tgl_masuk]) }}',
                            method: 'GET',
                            data: {
                                term: query
                            },
                            success: function(data) {
                                searchObatSpinner.hide();
                                var html = '';
                                if (data.length > 0) {
                                    data.forEach(function(obat) {
                                        html +=
                                            '<a href="#" class="list-group-item list-group-item-action" ' +
                                            'data-id="' + obat.id + '" ' +
                                            'data-harga="' + obat.harga + '" ' +
                                            'data-satuan="' + obat.satuan +
                                            '">' +
                                            obat.text + '</a>';
                                    });
                                } else {
                                    html =
                                        '<div class="list-group-item text-muted">Tidak ada hasil yang ditemukan</div>';
                                }
                                obatList.html(html);
                            },
                            error: function(xhr, status, error) {
                                searchObatSpinner.hide();
                                obatList.html(
                                    '<div class="list-group-item text-danger">Terjadi kesalahan saat mencari obat</div>'
                                );
                            }
                        });
                    } else {
                        obatList.html('');
                        searchObatSpinner.hide();
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
                satuanObat.val(obatSatuan);
                $('#hargaObat').val(obatHarga);
                obatList.html('');
                clearObat.show();
            });

            clearObat.on('click', function() {
                cariObat.val('').prop('readonly', false);
                selectedObatId.val('');
                satuanObat.val('');
                $('#hargaObat').val('');
                clearObat.hide();
                obatList.html('');
            });

            function resetInputObat() {
                $('#cariObat').val('').prop('readonly', false);
                $('#selectedObatId').val('');
                $('#jumlah').val('12');
                $('#aturanTambahan').val('');
                $('#clearObat').hide();
                $('#obatList').html('');
                $('#hargaObat').val('');
                $('#satuanObat').val('tablet');
            }

            // Set tanggal dan waktu default saat halaman dimuat
            function setDefaultDateTime() {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');

                $('#tanggalOrder').val(`${year}-${month}-${day}T${hours}:${minutes}`);
            }

            // Panggil fungsi untuk set default tanggal dan waktu
            setDefaultDateTime();

            // Inisialisasi input hidden pertama kali
            updateObatInputs();
        });
    </script>
@endpush
