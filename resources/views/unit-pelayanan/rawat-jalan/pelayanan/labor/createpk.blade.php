@push('css')
    <style>
        .dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
@endpush

<div class="d-grid gap-2">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLaborModal" type="button">
        <i class="ti-plus"></i> Tambah
    </button>
</div>

<div class="modal fade" id="addLaborModal" tabindex="-1" aria-labelledby="addLaborModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form
                action="{{ route('rawat-jalan.lab-patologi-klinik.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post">
                @csrf
                <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                <input type="hidden" name="tgl_masuk"
                    value="{{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d H:i:s') }}">
                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="addLaborModalLabel">
                        Order Pemeriksaan Laboratorium Klinik
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="patient-card">
                                <label for="kd_dokter" class="form-label fw-bold h5 text-dark">Dokter Pengirim:</label>
                                <select id="kd_dokter" name="kd_dokter" class="form-select"
                                    aria-label="Pilih dokter pengirim" required>
                                    <option value="" disabled selected>-Pilih Dokter Pengirim-</option>
                                    @foreach ($dataDokter as $d)
                                        <option value="{{ $d->dokter->kd_dokter }}" @selected($d->dokter->kd_karyawan == auth()->user()->kd_karyawan)>
                                            {{ $d->dokter->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="row">
                                    <div class="col-12">
                                        <label for="tgl_order" class="form-label fw-bold h5 text-dark">Tanggal & Jam
                                            Order:</label>
                                        <input type="datetime-local" id="tgl_order" name="tgl_order"
                                            class="form-control"
                                            value="{{ old('tgl_order', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label fw-bold h5 text-dark">Cito?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cyto" value="1"
                                                id="cyto_yes" {{ old('cyto') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cyto_yes">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cyto" value="0"
                                                id="cyto_no" {{ old('cyto', '0') == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cyto_no">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold h5 text-dark">Puasa?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puasa" value="1"
                                                id="puasa_yes" {{ old('puasa') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="puasa_yes">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puasa" value="0"
                                                id="puasa_no" {{ old('puasa', '0') == '0' ? 'checked' : '' }}>
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
                                    <div class="col-12">
                                        <label for="jadwal_pemeriksaan" class="form-label fw-bold h5 text-dark">Tanggal
                                            & Jam Pemeriksaan:</label>
                                        <input type="datetime-local" id="jadwal_pemeriksaan"
                                            name="jadwal_pemeriksaan" class="form-control">
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="patient-card mt-4">
                                <h6 class="fw-bold">Catatan Klinis/Diagnosis</h6>
                                <textarea class="form-control" id="diagnosis" name="diagnosis" readonly>{{ $diagnosisText ?: '-' }}</textarea>
                            </div> --}}
                            <div class="patient-card mt-4">
                                <h6 class="fw-bold">Catatan Klinis/Diagnosis</h6>
                                <div class="diagnosis-list">
                                    @if(count($diagnosisList) > 0)
                                        <ul class="list-unstyled mb-0">
                                            @foreach($diagnosisList as $diagnosis)
                                                <li class="mb-2">
                                                    <i class="fas fa-circle-notch me-2 text-primary"></i>
                                                    {{ $diagnosis }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="mb-0">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-md-4">
                            <div class="patient-card">
                                <p class="fw-bold">Pilih Jenis Pemeriksaan</p>
                                <select id="jenis_pemeriksaan" name="jenis_pemeriksaan" class="form-select"
                                    aria-label="Pilih jenis pemeriksaan">
                                    <option value="" disabled selected>--Pilih Kategori--</option>
                                    @foreach ($DataLapPemeriksaan as $kategori => $items)
                                        <option value="{{ $kategori }}"
                                            {{ old('jenis_pemeriksaan') == $kategori ? 'selected' : '' }}>
                                            {{ $kategori }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="dropdown mt-3">
                                    <input type="text" class="form-control mt-3" id="searchInput"
                                        placeholder="Cari produk..." autocomplete="off">
                                    <ul class="dropdown-menu w-100" id="dataList" aria-labelledby="searchInput"
                                        style="display: none;"></ul>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <div class="patient-card">
                                <p class="fw-bold">Pilih Jenis Pemeriksaan</p>
                                <div class="dropdown mt-3">
                                    <input type="text" class="form-control" id="searchInput"
                                        name="jenis_pemeriksaan" placeholder="Cari pemeriksaan..."
                                        autocomplete="off">
                                    <ul class="dropdown-menu w-100" id="dataList" aria-labelledby="searchInput"
                                        style="display: none;"></ul>
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
    <script>
        // code baru
        $(document).ready(function() {
            const $searchInput = $('#searchInput');
            const $dataList = $('#dataList');
            const $orderList = $('#orderList');
            const dataPemeriksaan = @json($DataLapPemeriksaan);

            let urut = 1;
            let allProducts = [];

            // Flatten the nested data structure to get all products
            Object.values(dataPemeriksaan).forEach(category => {
                category.forEach(item => {
                    if (!allProducts.some(p => p.produk.kd_produk === item.produk.kd_produk)) {
                        allProducts.push(item);
                    }
                });
            });

            $searchInput.on('focus', function() {
                showFilteredProducts('');
            });

            $searchInput.on('input', function() {
                const inputValue = $(this).val().toLowerCase();
                showFilteredProducts(inputValue);
            });

            function showFilteredProducts(searchTerm) {
                $dataList.empty();
                const addedDescriptions = new Set();

                allProducts.forEach(item => {
                    if (item.produk.deskripsi.toLowerCase().includes(searchTerm) &&
                        !addedDescriptions.has(item.produk.deskripsi)) {

                        addedDescriptions.add(item.produk.deskripsi);
                        const $li = $('<li>');
                        $li.html(
                            `<a class="dropdown-item" href="#" data-kd-produk="${item.produk.kd_produk}">${item.produk.deskripsi}</a>`
                        );
                        $dataList.append($li);
                    }
                });

                if ($dataList.children().length > 0) {
                    $dataList.show();
                } else {
                    $dataList.hide();
                }
            }

            $dataList.on('click', '.dropdown-item', function(e) {
                e.preventDefault();

                const selectedItemText = $(this).text();
                const kdProduk = $(this).attr('data-kd-produk');

                if (kdProduk) {
                    const $listItem = $('<li>').addClass('list-group-item');

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

        $('#addLaborModal').on('shown.bs.modal', function(e) {
            let $this = $(this);

            @cannot('is-admin')
                @cannot('is-perawat')
                    @cannot('is-bidan')
                        $this.find('#kd_dokter').mousedown(function(e) {
                            e.preventDefault();
                        });
                    @endcannot
                @endcannot
            @endcannot
        });

        // $('#addLaborModal').on('shown.bs.modal', function(e) {
        //     let $this = $(this);

        //     $this.find('#kd_dokter').mousedown(function(e) {
        //         e.preventDefault();
        //     });
        // });

        // code lama
        // $(document).ready(function() {
        //     const $searchInput = $('#searchInput');
        //     const $dataList = $('#dataList');
        //     const $orderList = $('#orderList');
        //     const $jenisPemeriksaanSelect = $('#jenis_pemeriksaan');
        //     const dataPemeriksaan = @json($DataLapPemeriksaan);
        //     // console.log(dataPemeriksaan);

        //     let urut = 1;

        //     $searchInput.on('focus', function() {
        //         if ($jenisPemeriksaanSelect.val()) {
        //             $dataList.show();
        //         }
        //     });

        //     $jenisPemeriksaanSelect.on('change', function() {
        //         const selectedCategory = $(this).val();
        //         // console.log(selectedCategory);

        //         $dataList.empty();
        //         const addedDescriptions = new Set();

        //         if (dataPemeriksaan[selectedCategory]) {
        //             $.each(dataPemeriksaan[selectedCategory], function(index, item) {
        //                 if (!addedDescriptions.has(item.produk.deskripsi)) {
        //                     addedDescriptions.add(item.produk
        //                         .deskripsi);
        //                     const $li = $('<li>');
        //                     $li.html(
        //                         `<a class="dropdown-item" href="#" data-kd-produk="${item.produk.kd_produk}">${item.produk.deskripsi}</a>`
        //                     );
        //                     $dataList.append($li);
        //                 }
        //             });
        //         }

        //         $searchInput.val('');
        //         $dataList.show();
        //     });

        //     $searchInput.on('input', function() {
        //         const inputValue = $(this).val().toLowerCase();
        //         $dataList.empty();

        //         if ($jenisPemeriksaanSelect.val()) {
        //             const selectedCategory = $jenisPemeriksaanSelect.val();
        //             const addedDescriptions =
        //                 new Set();

        //             if (dataPemeriksaan[selectedCategory]) {
        //                 $.each(dataPemeriksaan[selectedCategory], function(index, item) {
        //                     if (item.produk.deskripsi.toLowerCase().includes(inputValue) && !
        //                         addedDescriptions.has(item.produk.deskripsi)) {
        //                         addedDescriptions.add(item.produk
        //                             .deskripsi);
        //                         const $li = $('<li>');
        //                         $li.html(
        //                             `<a class="dropdown-item" href="#" data-kd-produk="${item.produk.kd_produk}">${item.produk.deskripsi}</a>`
        //                         );
        //                         $dataList.append($li);
        //                     }
        //                 });
        //             }

        //             if ($dataList.children().length > 0) {
        //                 $dataList.show();
        //             } else {
        //                 $dataList.hide();
        //             }
        //         }
        //     });

        //     $dataList.on('click', '.dropdown-item', function(e) {
        //         e.preventDefault();

        //         const selectedItemText = $(this).text();
        //         const kdProduk = $(this).attr('data-kd-produk');
        //         // console.log(kdProduk);

        //         if (kdProduk) {
        //             const $listItem = $('<li>').addClass('list-group-item');

        //             $listItem.html(`
        //             ${selectedItemText}
        //             <input type="hidden" name="kd_produk[]" value="${kdProduk}">
        //             <input type="hidden" name="jumlah[]" value="1">
        //             <input type="hidden" name="status[]" value="1">
        //             <input type="hidden" name="urut[]" value="${urut}">
        //             <span class="remove-item" style="color: red; cursor: pointer;">
        //                 <i class="bi bi-x-circle"></i>
        //             </span>
        //         `);

        //             $orderList.append($listItem);
        //             urut++;

        //             $listItem.find('.remove-item').on('click', function() {
        //                 $(this).closest('li').remove();
        //                 urut--;
        //                 // console.log(urut);
        //             });

        //             $searchInput.val('');
        //             $dataList.hide();
        //         } else {
        //             console.error('Error: kd_produk is undefined');
        //         }
        //     });

        //     $(document).on('click', function(event) {
        //         if (!$(event.target).closest('.dropdown').length && event.target !== $searchInput[0]) {
        //             $dataList.hide();
        //         }
        //     });
        // });

        // $('#addLaborModal').on('shown.bs.modal', function() {
        //     let $this = $(this);

        //     $this.find('#kd_dokter').mousedown(function(e) {
        //         e.preventDefault();
        //     });
        // });
    </script>
@endpush
