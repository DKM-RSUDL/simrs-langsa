@push('css')
    <style>
        .dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
@endpush

<!-- Modal untuk Edit -->
<div class="modal fade" id="extraLargeModal{{ str_replace('.', '_', $laborPK->kd_order) }}" tabindex="-1"
    aria-labelledby="extraLargeModalLabel{{str_replace('.', '_', $laborPK->kd_order) }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form
                action="{{ route('labor.update', ['kd_pasien' => $laborPK->kd_pasien, 'tgl_masuk' => $laborPK->tgl_masuk, 'labor' => $laborPK->kd_order]) }}"
                method="post">
                @csrf
                @method('PUT') {{-- Method PUT untuk update --}}
                <input type="hidden" name="kd_pasien" value="{{ $laborPK->kd_pasien }}">
                <input type="hidden" name="kd_unit" value="{{ $laborPK->kd_unit }}">
                <input type="hidden" name="tgl_masuk"
                    value="{{ \Carbon\Carbon::parse($laborPK->tgl_masuk)->format('Y-m-d H:i:s') }}">
                <input type="hidden" name="urut_masuk" value="{{ $laborPK->urut_masuk }}">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="extraLargeModalLabel{{ $laborPK->kd_order }}">
                        Edit Pemeriksaan Laboratorium Klinik
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="patient-card">
                                <label for="kd_dokter" class="form-label fw-bold h5 text-dark">Dokter Pengirim:</label>
                                <select id="kd_dokter" name="kd_dokter" class="form-select">
                                    <option value="" disabled>-Pilih Dokter Pengirim-</option>
                                    @foreach ($dataDokter as $dokter)
                                        <option value="{{ $dokter->kd_dokter }}"
                                            {{ old('kd_dokter', $laborPK->kd_dokter) == $dokter->kd_dokter ? 'selected' : '' }}>
                                            {{ $dokter->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="patient-card mt-4">
                                <label for="tgl_order" class="form-label fw-bold h5 text-dark">Tanggal & Jam
                                    Order:</label>
                                <input type="datetime-local" id="tgl_order" name="tgl_order" class="form-control"
                                    value="{{ old('tgl_order', \Carbon\Carbon::parse($laborPK->tgl_order)->format('Y-m-d\TH:i')) }}">
                            </div>

                            <div class="patient-card mt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label fw-bold h5 text-dark">Cito?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cyto" value="1"
                                                id="cyto_yes{{ $laborPK->kd_order }}"
                                                {{ old('cyto', $laborPK->cyto) == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="cyto_yes{{ $laborPK->kd_order }}">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cyto" value="0"
                                                id="cyto_no{{ $laborPK->kd_order }}"
                                                {{ old('cyto', $laborPK->cyto) == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="cyto_no{{ $laborPK->kd_order }}">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold h5 text-dark">Puasa?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puasa" value="1"
                                                id="puasa_yes{{ $laborPK->kd_order }}"
                                                {{ old('puasa', $laborPK->puasa) == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="puasa_yes{{ $laborPK->kd_order }}">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puasa" value="0"
                                                id="puasa_no{{ $laborPK->kd_order }}"
                                                {{ old('puasa', $laborPK->puasa) == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="puasa_no{{ $laborPK->kd_order }}">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <label for="jadwal_pemeriksaan" class="form-label fw-bold h5 text-dark">Jadwal
                                    Pemeriksaan:</label>
                                <input type="datetime-local" id="jadwal_pemeriksaan{{ $laborPK->kd_order }}"
                                    name="jadwal_pemeriksaan" class="form-control"
                                    value="{{ old('jadwal_pemeriksaan', $laborPK->jadwal_pemeriksaan) }}">
                            </div>

                            <div class="patient-card mt-4">
                                <label for="diagnosis" class="form-label fw-bold h5 text-dark">Catatan
                                    Klinis/Diagnosis</label>
                                <textarea class="form-control" id="diagnosis{{ $laborPK->kd_order }}" name="diagnosis">{{ old('diagnosis', $laborPK->diagnosis) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="patient-card">
                                <p class="fw-bold">Pilih Jenis Pemeriksaan</p>
                                <select id="jenis__pemeriksaan" name="jenis_pemeriksaan" class="form-select"
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
                                    <input type="text" class="form-control mt-3" id="search__input"
                                        placeholder="Cari produk..." autocomplete="off">
                                    <ul class="dropdown-menu w-100" id="data__list" aria-labelledby="searchInput"
                                        style="display: none;"></ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="patient-card">
                                <h6 class="fw-bold">Daftar Order Pemeriksaan</h6>
                                <ul id="order__list" class="list-group">
                                    @if (isset($laborPK->details) && $laborPK->details->count() > 0)
                                        @foreach ($laborPK->details as $orderDetail)
                                            <li class="list-group-item">
                                                {{ $orderDetail->produk->deskripsi ?? 'Produk tidak ditemukan' }}
                                                <input type="hidden" name="kd_produk[]"
                                                    value="{{ $orderDetail->kd_produk }}" required>
                                                <input type="hidden" name="jumlah[]"
                                                    value="{{ (int) $orderDetail->jumlah }}">
                                                <input type="hidden" name="status[]"
                                                    value="{{ $orderDetail->status }}">
                                                <input type="hidden" name="urut[]" value="{{ $loop->iteration }}"
                                                    required>
                                                <span class="remove-item" style="color: red; cursor: pointer;">
                                                    <i class="bi bi-x-circle"></i>
                                                </span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
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
        $(document).ready(function() {
            const $searchInput = $('#search__input');
            const $dataList = $('#data__list');
            const $orderList = $('#order__list');
            const $jenisPemeriksaanSelect = $('#jenis__pemeriksaan');
            const dataPemeriksaan = @json($DataLapPemeriksaan);
            const existingOrders = @json($laborPK->details);
            // console.log('Data Pemeriksaan:', dataPemeriksaan);
            // console.log('Existing Orders:', existingOrders);

            let urut = 1;

            function updateDataList(selectedCategory, inputValue = '') {
                $dataList.empty();
                const addedDescriptions = new Set();

                if (dataPemeriksaan[selectedCategory]) {
                    $.each(dataPemeriksaan[selectedCategory], function(index, item) {
                        if ((inputValue === '' || item.produk.deskripsi.toLowerCase().includes(inputValue
                                .toLowerCase())) &&
                            !addedDescriptions.has(item.produk.deskripsi)) {
                            addedDescriptions.add(item.produk.deskripsi);
                            const $li = $('<li>');
                            $li.html(
                                `<a class="dropdown-item" href="#" data-kd-produk="${item.produk.kd_produk}">${item.produk.deskripsi}</a>`
                            );
                            $dataList.append($li);
                        }
                    });
                }

                if ($dataList.children().length > 0) {
                    $dataList.show();
                } else {
                    $dataList.hide();
                }
                // console.log('Data list updated:', $dataList.children().length, 'items');
            }

            function addItemToOrderList(kdProduk, deskripsi, jumlah = 1, status = 1) {
                // Check if item already exists in the list
                const existingItem = $orderList.find(`input[name="kd_produk[]"][value="${kdProduk}"]`).closest(
                    'li');
                if (existingItem.length) {
                    // console.log('Item already exists in order list:', deskripsi);
                    return; // If item exists, don't add it again
                }

                const $listItem = $('<li>').addClass('list-group-item');
                $listItem.html(`
            ${deskripsi}
            <input type="hidden" name="kd_produk[]" value="${kdProduk}" required>
            <input type="hidden" name="jumlah[]" value="${jumlah}">
            <input type="hidden" name="status[]" value="${status}">
            <input type="hidden" name="urut[]" value="${urut}" required>
            <span class="remove-item" style="color: red; cursor: pointer;">
                <i class="bi bi-x-circle"></i>
            </span>
        `);
                $orderList.append($listItem);
                urut++;
                // console.log('Item added to order list:', deskripsi);
            }

            function populateOrderList() {
                $orderList.empty();
                urut = 1;
                if (existingOrders && existingOrders.length > 0) {
                    existingOrders.forEach(function(order) {
                        addItemToOrderList(order.kd_produk, order.produk.deskripsi, order.jumlah, order
                            .status);
                    });
                }
                // console.log('Order list populated with', existingOrders.length, 'items');
            }

            $jenisPemeriksaanSelect.off('change').on('change', function() {
                const selectedCategory = $(this).val();
                // console.log('Selected category:', selectedCategory);
                updateDataList(selectedCategory);
            });

            $searchInput.off('input').on('input', function() {
                const inputValue = $(this).val().toLowerCase();
                const selectedCategory = $jenisPemeriksaanSelect.val();
                if (selectedCategory) {
                    updateDataList(selectedCategory, inputValue);
                }
            });

            $dataList.off('click', '.dropdown-item').on('click', '.dropdown-item', function(e) {
                e.preventDefault();
                const selectedItemText = $(this).text();
                const kdProduk = $(this).attr('data-kd-produk');
                // console.log('Selected product:', kdProduk, selectedItemText);

                if (kdProduk) {
                    addItemToOrderList(kdProduk, selectedItemText);
                    $searchInput.val('');
                    $dataList.hide();
                } else {
                    console.error('Error: kd_produk is undefined');
                }
            });

            $orderList.off('click', '.remove-item').on('click', '.remove-item', function() {
                $(this).closest('li').remove();
                updateUrut();
                console.log('Item removed from order list');
            });

            function updateUrut() {
                urut = 1;
                $orderList.find('li').each(function() {
                    $(this).find('input[name="urut[]"]').val(urut);
                    urut++;
                });
                console.log('Urut updated');
            }

            $(document).off('click.hideDataList').on('click.hideDataList', function(event) {
                if (!$(event.target).closest('.dropdown').length && event.target !== $searchInput[0]) {
                    $dataList.hide();
                }
            });

            // Set initial jenis pemeriksaan if available
            if (existingOrders && existingOrders.length > 0) {
                const firstOrder = existingOrders[0];
                const kategori = Object.keys(dataPemeriksaan).find(key =>
                    dataPemeriksaan[key].some(item => item.produk.kd_produk === firstOrder.kd_produk)
                );
                if (kategori) {
                    $jenisPemeriksaanSelect.val(kategori).trigger('change');
                    // console.log('Initial category set:', kategori);
                }
            }

            // Show data list when search input is focused
            $searchInput.off('focus').on('focus', function() {
                const selectedCategory = $jenisPemeriksaanSelect.val();
                if (selectedCategory) {
                    updateDataList(selectedCategory);
                }
            });
        });
    </script>
@endpush
