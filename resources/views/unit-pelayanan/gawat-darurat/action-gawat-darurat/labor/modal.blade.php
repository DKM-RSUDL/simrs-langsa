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
                                    <option value="1">Dokter A</option>
                                    <option value="2">Dokter B</option>
                                    <option value="3">Dokter C</option>
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
                                <select id="jenis_pemeriksaan" name="jenis_pemeriksaan" class="form-select"
                                    aria-label="Pilih dokter pengirim">
                                    <option value="" disabled selected>--Semua--</option>
                                    <option value="1">Pilih A</option>
                                    <option value="2">Pilih B</option>
                                    <option value="3">Pilih C</option>
                                </select>

                                <div class="dropdown mt-3">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Cari data..." autocomplete="off">
                                    <ul class="dropdown-menu w-100" id="dataList" aria-labelledby="searchInput" style="display: none;">
                                        @foreach($DataLapPemeriksaan as $item)
                                            <li><a class="dropdown-item" href="#">{{ $item->nama }}</a></li>
                                        @endforeach
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

        // dropdown saat input di klik
        searchInput.addEventListener('focus', function() {
            dataList.style.display = 'block';
        });

        // dropdown user mulai mengetik
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

            // Jika tidak ada item yang cocok, sembunyikan dropdown
            if (hasVisibleItems) {
                dataList.style.display = 'block';
            } else {
                dataList.style.display = 'none';
            }
        });

        // Event listener untuk klik pada item dropdown (menggunakan delegation)
        document.querySelector('#dataList').addEventListener('click', function(e) {
            if (e.target.classList.contains('dropdown-item')) {
                const selectedItemText = e.target.textContent;

                // Memindahkan item yang dipilih ke orderList dengan tombol hapus
                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                listItem.innerHTML = `
                    ${selectedItemText}
                    <span class="remove-item" style="color: red; cursor: pointer;"><i class="bi bi-x-circle"></i></span>
                `;
                orderList.appendChild(listItem);

                // Set value input ke item yang dipilih dan tutup dropdown
                searchInput.value = '';
                dataList.style.display = 'none';

                // Event listener untuk menghapus item dari daftar
                listItem.querySelector('.remove-item').addEventListener('click', function() {
                    listItem.remove();
                });
            }
        });

        // Menyembunyikan dropdown saat klik di luar elemen dropdown
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                dataList.style.display = 'none';
            }
        });
    });
</script>
@endpush
