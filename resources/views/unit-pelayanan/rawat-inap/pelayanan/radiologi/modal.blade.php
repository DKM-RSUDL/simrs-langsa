@push('css')
    <style>
        .dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
@endpush

<div class="d-grid gap-2">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRadiologiModal" type="button">
        <i class="ti-plus"></i> Tambah
    </button>
</div>

<div class="modal fade" id="addRadiologiModal" tabindex="-1" aria-labelledby="addRadiologiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form
                action="{{ route('rawat-inap.radiologi.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post">
                @csrf

                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="addRadiologiModalLabel">
                        Order Pemeriksaan Radiologi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="patient-card">
                                <label for="kd_dokter" class="form-label fw-bold h5 text-dark">Dokter Pengirim:</label>
                                <select id="kd_dokter" name="kd_dokter"
                                    class="form-select @error('kd_dokter') is-invalid @enderror"
                                    aria-label="Pilih dokter pengirim" required>
                                    <option value="">-Pilih Dokter Pengirim-</option>
                                    @foreach ($dokter as $dok)
                                        <option value="{{ $dok->dokter->kd_dokter }}" @selected($dok->dokter->kd_karyawan == auth()->user()->kd_karyawan)>
                                            {{ $dok->dokter->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                                @error('kd_dokter')
                                    <div class="invalid-feedback">
                                        {{ $error }}
                                    </div>
                                @enderror

                                <div class="row">
                                    <div class="col-7">
                                        <label for="tgl_order" class="form-label fw-bold h5 text-dark">Tanggal
                                            Order:</label>
                                        <input type="date" id="tgl_order" name="tgl_order"
                                            class="form-control @error('tgl_order') is-invalid @enderror"
                                            value="{{ old('tgl_order', date('Y-m-d')) }}" required>
                                        @error('tgl_order')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-5">
                                        <label for="jam_order" class="form-label fw-bold h5 text-dark">Jam</label>
                                        <input type="time" id="jam_order" name="jam_order"
                                            class="form-control @error('jam_order') is-invalid @enderror"
                                            value="{{ old('jam_order', date('H:i')) }}" required>
                                        @error('jam_order')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label fw-bold h5 text-dark">Cito?</label>
                                        <div class="form-check">
                                            <input class="form-check-input @error('cyto') is-invalid @enderror"
                                                type="radio" name="cyto" value="1" id="cyto_yes"
                                                @checked(old('cyto') == 1) required>
                                            <label class="form-check-label" for="cyto_yes">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('cyto') is-invalid @enderror"
                                                type="radio" name="cyto" value="0" id="cyto_no"
                                                @checked(old('cyto') == 0) required>
                                            <label class="form-check-label" for="cyto_no">Tidak</label>
                                        </div>
                                        @error('cyto')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <h6 class="fw-bold">Jadwal Pemeriksaan</h6>
                                <p class="text-muted">
                                    Tanggal ini diisi jika pemeriksaan radiologi dijadwalkan bukan pada hari ini.
                                </p>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-7">
                                            <label for="tgl_pemeriksaan"
                                                class="form-label fw-bold h5 text-dark">Tanggal:</label>
                                            <input type="date" id="tgl_pemeriksaan" name="tgl_pemeriksaan"
                                                class="form-control" value="{{ old('tgl_pemeriksaan') }}">
                                        </div>

                                        <div class="col-5">
                                            <label for="jam_pemeriksaan"
                                                class="form-label fw-bold h5 text-dark">Jam:</label>
                                            <input type="time" id="jam_pemeriksaan" name="jam_pemeriksaan"
                                                class="form-control" value="{{ old('jam_pemeriksaan') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <h6 class="fw-bold">Catatan Klinis/Diagnosis</h6>
                                <textarea class="form-control" id="diagnosis" name="diagnosis">{{ old('diagnosis') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="patient-card">
                                {{-- <select id="jenis_pemeriksaan" name="jenis_pemeriksaan" class="form-select" aria-label="Pilih jenis pemeriksaan">
                                    <option value="" disabled selected>--Pilih Kategori--</option>
                                </select> --}}

                                <div class="dropdown mt-3">
                                    <input type="text" class="form-control mt-3" id="searchInput"
                                        placeholder="Cari produk..." autocomplete="off">
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

<div class="modal fade" id="editRadiologiModal" tabindex="-1" aria-labelledby="editRadiologiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form
                action="{{ route('rawat-inap.radiologi.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post">
                @csrf
                @method('put')

                <input type="hidden" id="kd_order" name="kd_order">
                <input type="hidden" id="urut_masuk" name="urut_masuk">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="editRadiologiModalLabel">
                        Edit Pemeriksaan Radiologi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="patient-card">
                                <label for="kd_dokter" class="form-label fw-bold h5 text-dark">Dokter
                                    Pengirim:</label>
                                <select id="kd_dokter" name="kd_dokter"
                                    class="form-select @error('kd_dokter') is-invalid @enderror"
                                    aria-label="Pilih dokter pengirim" required>
                                    <option value="">-Pilih Dokter Pengirim-</option>
                                    @foreach ($dokter as $dok)
                                        <option value="{{ $dok->dokter->kd_dokter }}" @selected(old('kd_dokter') == $dok->dokter->kd_dokter)>
                                            {{ $dok->dokter->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                                @error('kd_dokter')
                                    <div class="invalid-feedback">
                                        {{ $error }}
                                    </div>
                                @enderror

                                <div class="row">
                                    <div class="col-7">
                                        <label for="tgl_order" class="form-label fw-bold h5 text-dark">Tanggal
                                            Order:</label>
                                        <input type="date" id="tgl_order" name="tgl_order"
                                            class="form-control @error('tgl_order') is-invalid @enderror"
                                            value="{{ old('tgl_order') }}" required>
                                        @error('tgl_order')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-5">
                                        <label for="jam_order" class="form-label fw-bold h5 text-dark">Jam</label>
                                        <input type="time" id="jam_order" name="jam_order"
                                            class="form-control @error('jam_order') is-invalid @enderror"
                                            value="{{ old('jam_order') }}" required>
                                        @error('jam_order')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label fw-bold h5 text-dark">Cito?</label>
                                        <div class="form-check">
                                            <input class="form-check-input @error('cyto') is-invalid @enderror"
                                                type="radio" name="cyto" value="1" id="cyto_yes"
                                                @checked(old('cyto') == 1) required>
                                            <label class="form-check-label" for="cyto_yes">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('cyto') is-invalid @enderror"
                                                type="radio" name="cyto" value="0" id="cyto_no"
                                                @checked(old('cyto') == 0) required>
                                            <label class="form-check-label" for="cyto_no">Tidak</label>
                                        </div>
                                        @error('cyto')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <h6 class="fw-bold">Jadwal Pemeriksaan</h6>
                                <p class="text-muted">
                                    Tanggal ini diisi jika pemeriksaan radiologi dijadwalkan bukan pada hari ini.
                                </p>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-7">
                                            <label for="tgl_pemeriksaan"
                                                class="form-label fw-bold h5 text-dark">Tanggal:</label>
                                            <input type="date" id="tgl_pemeriksaan" name="tgl_pemeriksaan"
                                                class="form-control" value="{{ old('tgl_pemeriksaan') }}">
                                        </div>

                                        <div class="col-5">
                                            <label for="jam_pemeriksaan"
                                                class="form-label fw-bold h5 text-dark">Jam:</label>
                                            <input type="time" id="jam_pemeriksaan" name="jam_pemeriksaan"
                                                class="form-control" value="{{ old('jam_pemeriksaan') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="patient-card mt-4">
                                <h6 class="fw-bold">Catatan Klinis/Diagnosis</h6>
                                <textarea class="form-control" id="diagnosis" name="diagnosis">{{ old('diagnosis') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="patient-card">
                                {{-- <select id="jenis_pemeriksaan" name="jenis_pemeriksaan" class="form-select" aria-label="Pilih jenis pemeriksaan">
                                    <option value="" disabled selected>--Pilih Kategori--</option>
                                </select> --}}

                                <div class="dropdown mt-3">
                                    <input type="text" class="form-control mt-3" id="searchInput"
                                        placeholder="Cari produk..." autocomplete="off">
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

<div class="modal fade" id="showRadiologiModal" tabindex="-1" aria-labelledby="showRadiologiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="showRadiologiModalLabel">
                    Detail Pemeriksaan Radiologi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="patient-card">
                            <div class="row">
                                <div class="col-12">
                                    <p class="p-0 m-0"><strong>Dokter pengirim :</strong></p>
                                    <p class="p-0 m-0" id="dokter"></p>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <p class="p-0 m-0"><strong>Jadwal Order :</strong></p>
                                    <p class="p-0 m-0" id="jadwal_order"></p>
                                </div>
                            </div>
                        </div>

                        <div class="patient-card mt-4">
                            <div class="row">
                                <div class="col-6">
                                    <p class="p-0 m-0"><strong>Cito :</strong> <span id="cyto"></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="patient-card mt-4">
                            <div class="row">
                                <div class="col-12">
                                    <p class="p-0 m-0"><strong>Jadwal Pemeriksaan :</strong></p>
                                    <p class="p-0 m-0" id="jadwal_pemeriksaan"></p>
                                </div>
                            </div>
                        </div>

                        <div class="patient-card mt-4">
                            <div class="row">
                                <div class="col-12">
                                    <p class="p-0 m-0"><strong>Catatan Klinis/Diagnosis :</strong></p>
                                    <p class="p-0 m-0" id="diagnosis">Tidak ada diagnosis</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="patient-card">
                            <h6 class="fw-bold">Daftar Pemeriksaan</h6>
                            <ul id="orderList" class="list-group">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>

@push('js')
    <script>
        // const $jenisPemeriksaanSelect = $('#jenis_pemeriksaan');
        const $searchInput = $('#addRadiologiModal #searchInput');
        const $dataList = $('#addRadiologiModal #dataList');
        const $orderList = $('#addRadiologiModal #orderList');

        function dataPemeriksaanItem() {
            const dataPemeriksaan = @json($produk);
            var listHtml = '';

            dataPemeriksaan.forEach(item => {
                listHtml +=
                    `<a class="dropdown-item" href="#" data-kd-produk="${item.kp_produk}">${item.deskripsi}</a>`;
            });

            $dataList.html(listHtml);
            $dataList.show();
        }

        $searchInput.on('focus', function() {
            dataPemeriksaanItem();
        });

        $('#addRadiologiModal').on('shown.bs.modal', function() {
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
        })

        $('#editRadiologiModal').on('shown.bs.modal', function(e) {
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

        $('#addRadiologiModal #searchInput').keyup(function() {
            let $this = $(this);
            let search = $this.val();

            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {

                let dataSearch = searchDataPemeriksaan(search);
                let listHtml = '';

                dataSearch.forEach(item => {
                    listHtml +=
                        `<a class="dropdown-item" href="#" data-kd-produk="${item.kp_produk}">${item.deskripsi}</a>`;
                });

                $('#addRadiologiModal #dataList').html(listHtml);
                $('#addRadiologiModal #dataList').show();
            }, debounceTime)
        });

        $dataList.on('click', '.dropdown-item', function(e) {
            e.preventDefault();

            const selectedItemText = $(this).text();
            const kdProduk = $(this).attr('data-kd-produk');

            if (kdProduk) {
                const listItem = `<li class="list-group-item">
                                        ${selectedItemText}
                                        <input type="hidden" name="kd_produk[]" value="${kdProduk}">
                                        <span class="remove-item" style="color: red; cursor: pointer;">
                                            <i class="bi bi-x-circle"></i>
                                        </span>
                                    </li>`;

                $orderList.append(listItem);

                $searchInput.val('');
                $dataList.hide();
            } else {
                console.error('Error: kd_produk is undefined');
            }
        });

        $orderList.on('click', '.list-group-item .remove-item', function(e) {
            e.preventDefault();
            $(this).parent().remove();
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.dropdown').length && event.target !== $searchInput[0]) {
                $dataList.hide();
                $('#editRadiologiModal #dataList').hide();
            }
        });
    </script>
@endpush
