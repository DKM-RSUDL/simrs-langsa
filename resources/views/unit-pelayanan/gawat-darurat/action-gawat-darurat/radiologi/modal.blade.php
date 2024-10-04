@push('css')
    <style>
        .dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
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
            <form action="#" method="post">
                @csrf

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="extraLargeModalLabel">
                        Order Pemeriksaan Radiologi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="patient-card">
                                <label for="kd_dokter" class="form-label fw-bold h5 text-dark">Dokter Pengirim:</label>
                                <select id="kd_dokter" name="kd_dokter" class="form-select" aria-label="Pilih dokter pengirim" required>
                                    <option value="" disabled selected>-Pilih Dokter Pengirim-</option>
                                </select>

                                <div class="row">
                                    <div class="col-7">
                                        <label for="tgl_order" class="form-label fw-bold h5 text-dark">Tanggal Order:</label>
                                        <input type="date" id="tgl_order" name="tgl_order" class="form-control" required>
                                    </div>

                                    <div class="col-5">
                                        <label for="jam_order" class="form-label fw-bold h5 text-dark">Jam</label>
                                        <input type="time" id="jam_order" name="jam_order" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label fw-bold h5 text-dark">Cito?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cyto" value="1" id="cyto_yes" required>
                                            <label class="form-check-label" for="cyto_yes">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cyto" value="0" id="cyto_no" required>
                                            <label class="form-check-label" for="cyto_no">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold h5 text-dark">Puasa?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puasa" value="1" id="puasa_yes" required>
                                            <label class="form-check-label" for="puasa_yes">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puasa" value="0" id="puasa_no" required>
                                            <label class="form-check-label" for="puasa_no">Tidak</label>
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
                                    <div class="row">
                                        <div class="col-7">
                                            <label for="tgl_pemeriksaan" class="form-label fw-bold h5 text-dark">Tanggal:</label>
                                            <input type="date" id="tgl_pemeriksaan" name="tgl_pemeriksaan" class="form-control">
                                        </div>
    
                                        <div class="col-5">
                                            <label for="jam_pemeriksaan" class="form-label fw-bold h5 text-dark">Jam:</label>
                                            <input type="time" id="jam_pemeriksaan" name="jam_pemeriksaan" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <h6 class="fw-bold">Catatan Klinis/Diagnosis</h6>
                                <textarea class="form-control" id="diagnosis" name="diagnosis"></textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="patient-card">
                                <select id="jenis_pemeriksaan" name="jenis_pemeriksaan" class="form-select" aria-label="Pilih jenis pemeriksaan">
                                    <option value="" disabled selected>--Pilih Kategori--</option>
                                </select>

                                <div class="dropdown mt-3">
                                    <input type="text" class="form-control mt-3" id="searchInput" placeholder="Cari produk..." autocomplete="off">
                                    <ul class="dropdown-menu w-100" id="dataList" aria-labelledby="searchInput" style="display: none;"></ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="patient-card">
                                <h6 class="fw-bold">Daftar Order Pemeriksaan</h6>
                                <ul id="orderList" class="list-group"></ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    {{-- <script>
        $(document).ready(function() {
            const $searchInput = $('#searchInput');
            const $dataList = $('#dataList');
            const $orderList = $('#orderList');
            const $jenisPemeriksaanSelect = $('#jenis_pemeriksaan');
            const dataPemeriksaan = @json($DataLapPemeriksaan);
            console.log(dataPemeriksaan);

            let urut = 1;

            $searchInput.on('focus', function() {
                if ($jenisPemeriksaanSelect.val()) {
                    $dataList.show();
                }
            });

            $jenisPemeriksaanSelect.on('change', function() {
                const selectedCategory = $(this).val();
                console.log(selectedCategory);

                $dataList.empty();

                if (dataPemeriksaan[selectedCategory]) {
                    $.each(dataPemeriksaan[selectedCategory], function(index, item) {
                        console.log(item);
                        const $li = $('<li>');
                        $li.html(
                            `<a class="dropdown-item" href="#" data-kd-produk="${item.kd_produk}">${item.nama}</a>`
                        );
                        $dataList.append($li);
                    });
                }

                $searchInput.val('');
                $dataList.hide();
            });

            $dataList.on('click', '.dropdown-item', function(e) {
                e.preventDefault();

                const selectedItemText = $(this).text();
                const kdProduk = $(this).attr('data-kd-produk');
                console.log(kdProduk);

                if (kdProduk) {
                    const $listItem = $('<li>').addClass('list-group-item');

                    // Set hidden inputs dynamically
                    $listItem.html(`
                        ${selectedItemText}
                        <input type="hidden" name="kd_produk[]" value="${kdProduk}">
                        <input type="hidden" name="jumlah[]" value="1">
                        <input type="hidden" name="status[]" value="1">
                        <input type="hidden" name="urut[]" value="${urut}">
                        <span class="remove-item" style="color: red; cursor: pointer;">
                            <i class="bi bi-x-circle"></i>
                        </span>
                    `);

                    $orderList.append($listItem);

                    urut++;

                    $listItem.find('.remove-item').on('click', function() {
                        $(this).closest('li').remove();
                        urut--;
                        console.log(urut);
                    });

                    $searchInput.val('');
                    $dataList.hide();
                } else {
                    console.error('Error: kd_produk is undefined');
                }
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('.dropdown').length && event.target !== $searchInput[0]) {
                    $dataList.hide();
                }
            });
        });
    </script> --}}
@endpush
