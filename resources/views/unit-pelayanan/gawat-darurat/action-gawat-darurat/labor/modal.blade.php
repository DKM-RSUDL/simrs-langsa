@push('css')
    <style>
        .dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
        }

        #orderList li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 10px;
            border: 1px solid #ccc;
            margin-bottom: 3px;
        }

        .remove-item {
            color: red;
            cursor: pointer;
        }
    </style>
@endpush

<div class="d-grid gap-2">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#extraLargeModal" type="button">
        <i class="ti-plus"></i> Tambah
    </button>
</div>

<div class="modal fade" id="extraLargeModal" tabindex="-1" aria-labelledby="extraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="extraLargeModalLabel">
                        Order Pemeriksaan Laboratorium Klinik
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="patient-card">
                                <label for="dokter_pengirim" class="form-label fw-bold h5 text-dark">Dokter
                                    Pengirim:</label>
                                <select id="dokter_pengirim" name="dokter_pengirim" class="form-select"
                                    aria-label="Pilih dokter pengirim">
                                    <option value="" disabled selected>-Pilih Dokter Pengirim-</option>
                                    @foreach ($dataDokter as $dokter)
                                        <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                                    @endforeach
                                </select>

                                <div class="row">
                                    <div class="col-6">
                                        <label for="tanggal" class="form-label fw-bold h5 text-dark">Tanggal Order
                                            :</label>
                                        <input type="date" id="tanggal" name="tanggal" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <label for="jam" class="form-label fw-bold h5 text-dark">Jam:</label>
                                        <input type="time" id="jam" name="jam" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label fw-bold h5 text-dark">Cito?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cito" value="ya"
                                                id="citoYa">
                                            <label class="form-check-label" for="citoYa">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cito" value="tidak"
                                                id="citoTidak" checked>
                                            <label class="form-check-label" for="citoTidak">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold h5 text-dark">Puasa?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puasa" value="ya"
                                                id="puasaYa">
                                            <label class="form-check-label" for="puasaYa">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puasa" value="tidak"
                                                id="puasaTidak" checked>
                                            <label class="form-check-label" for="puasaTidak">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <h6 class="fw-bold">Jadwal Pemeriksaan</h6>
                                <p class="text-muted">
                                    Tanggal ini diisi jika pemeriksaan laboratorium dijadwalkan bukan pada hari ini.
                                </p>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="tanggal" class="form-label fw-bold h5 text-dark">Tanggal Order
                                            :</label>
                                        <input type="date" id="tanggal" name="tanggal" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <label for="jam" class="form-label fw-bold h5 text-dark">Jam:</label>
                                        <input type="time" id="jam" name="jam" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <h6 class="fw-bold">Catatan Klinis/Diagnosis</h6>
                                <textarea class="form-control" id="anamnesis"></textarea>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="patient-card">
                                <label for="jenis_pemeriksaan" class="form-label fw-bold h5 text-dark">
                                    Pilih Jenis Pemeriksaan
                                </label>
                                <select id="jenis_pemeriksaan" name="jenis_pemeriksaan" class="form-select" aria-label="Pilih jenis pemeriksaan">
                                    <option value="" disabled selected>--Semua--</option>
                                    @foreach($DataLapPemeriksaan as $kategori => $items)
                                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                                    @endforeach
                                </select>

                                <div class="dropdown mt-3">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Cari data..." autocomplete="off">
                                    <ul class="dropdown-menu w-100" id="dataList" aria-labelledby="searchInput" style="display: none;">
                                        <!-- Data nama yang difilter akan muncul di sini -->
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="patient-card">
                                <h6 class="fw-bold">Daftar Order Pemeriksaan Laboratorium</h6>
                                <ul id="orderList" class="list-group">
                                    <!-- Daftar order pemeriksaan yang dipilih akan muncul di sini -->
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const dataList = document.getElementById('dataList');
            const orderList = document.getElementById('orderList');
            const jenisPemeriksaanSelect = document.getElementById('jenis_pemeriksaan');

            // Ambil data dari controller dalam bentuk JSON
            const dataPemeriksaan = @json($DataLapPemeriksaan); // Data dari controller

            // Tampilkan dropdown saat input difokuskan
            searchInput.addEventListener('focus', function() {
                if (jenisPemeriksaanSelect.value) {
                    dataList.style.display = 'block';
                }
            });

            // untuk perubahan kategori di dropdown jenis pemeriksaan
            jenisPemeriksaanSelect.addEventListener('change', function() {
                const selectedCategory = this.value;

                // Reset dataList setiap kali kategori berubah
                dataList.innerHTML = '';

                // Tampilkan nama sesuai dengan kategori yang dipilih
                if (dataPemeriksaan[selectedCategory]) {
                    dataPemeriksaan[selectedCategory].forEach(item => {
                        const li = document.createElement('li');
                        li.innerHTML = `<a class="dropdown-item" href="#">${item.nama}</a>`;
                        dataList.appendChild(li);
                    });
                }

                // Reset search input value ketika kategori berubah
                searchInput.value = '';
                dataList.style.display = 'none';
            });

            // Filter data saat mengetik di input cari
            searchInput.addEventListener('input', function() {
                const filter = searchInput.value.toLowerCase();
                const items = dataList.querySelectorAll('.dropdown-item');
                let hasVisibleItems = false;

                items.forEach(function(item) {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(filter)) {
                        item.style.display = 'block';
                        hasVisibleItems = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (hasVisibleItems) {
                    dataList.style.display = 'block';
                } else {
                    dataList.style.display = 'none';
                }
            });

            // tambah item dari dropdown ke daftar order
            dataList.addEventListener('click', function(e) {
                if (e.target.classList.contains('dropdown-item')) {
                    const selectedItemText = e.target.textContent;

                    // Buat elemen baru dari order
                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item');
                    listItem.innerHTML = `
                        ${selectedItemText}
                        <span class="remove-item" style="color: red; cursor: pointer;"><i class="bi bi-x-circle"></i></span>
                    `;
                    orderList.appendChild(listItem);

                    // Hapus teks di input dan sembunyikan dropdown
                    searchInput.value = '';
                    dataList.style.display = 'none';

                    // hapus item dari daftar order
                    listItem.querySelector('.remove-item').addEventListener('click', function() {
                        listItem.remove();
                    });
                }
            });

            // simpan dropdown jika klik di luar dropdown
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown') && event.target !== searchInput) {
                    dataList.style.display = 'none';
                }
            });
        });
    </script>
@endpush

