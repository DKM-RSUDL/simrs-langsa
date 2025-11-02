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

{{-- ===================== ADD MODAL ===================== --}}
<div class="modal fade" id="addRadiologiModal" tabindex="-1" aria-labelledby="addRadiologiModalLabel" aria-hidden="true"
    dir="ltr">
    <div class="modal-dialog modal-xl text-start">
        <div class="modal-content text-start">
            <form
                action="{{ route('rawat-jalan.radiologi.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
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
                            <x-content-card>
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
                                        {{ $message }}
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
                                                {{ $message }}
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
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </x-content-card>

                            <x-content-card>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label fw-bold h5 text-dark">Cito?</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input @error('cyto') is-invalid @enderror"
                                                        type="radio" name="cyto" value="1" id="cyto_yes"
                                                        @checked(old('cyto') == 1) required>
                                                    <label class="form-check-label" for="cyto_yes">Ya</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input @error('cyto') is-invalid @enderror"
                                                        type="radio" name="cyto" value="0" id="cyto_no"
                                                        @checked(old('cyto') == 0) required>
                                                    <label class="form-check-label" for="cyto_no">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('cyto')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </x-content-card>

                            <x-content-card>
                                <h6 class="fw-bold">Jadwal Pemeriksaan</h6>
                                <p class="text-muted">
                                    Tanggal ini diisi jika pemeriksaan radiologi dijadwalkan bukan pada hari ini.
                                </p>
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
                            </x-content-card>

                            <x-content-card>
                                <h6 class="fw-bold">Catatan Klinis/Diagnosis</h6>
                                <textarea class="form-control" id="diagnosis" name="diagnosis">{{ old('diagnosis') }}</textarea>
                            </x-content-card>
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-12">
                                    <x-content-card>
                                        <div class="dropdown">
                                            <input type="text" class="form-control" id="searchInput"
                                                placeholder="Cari produk..." autocomplete="off">
                                            <ul class="dropdown-menu w-100 d-none" id="dataList"
                                                aria-labelledby="searchInput"></ul>
                                        </div>
                                    </x-content-card>
                                </div>
                                <div class="col-12">
                                    <x-content-card>
                                        <h6 class="fw-bold">Daftar Order Pemeriksaan</h6>
                                        <ul id="orderList" class="list-group"></ul>
                                    </x-content-card>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> {{-- /modal-body --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===================== EDIT MODAL ===================== --}}
<div class="modal fade" id="editRadiologiModal" tabindex="-1" aria-labelledby="editRadiologiModalLabel"
    aria-hidden="true" dir="ltr">
    <div class="modal-dialog modal-xl text-start">
        <div class="modal-content text-start">
            <form
                action="{{ route('rawat-jalan.radiologi.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
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
                            <x-content-card>
                                <label for="edit_kd_dokter" class="form-label fw-bold h5 text-dark">Dokter
                                    Pengirim:</label>
                                <select id="edit_kd_dokter" name="kd_dokter"
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
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="row">
                                    <div class="col-7">
                                        <label for="edit_tgl_order" class="form-label fw-bold h5 text-dark">Tanggal
                                            Order:</label>
                                        <input type="date" id="edit_tgl_order" name="tgl_order"
                                            class="form-control @error('tgl_order') is-invalid @enderror"
                                            value="{{ old('tgl_order') }}" required>
                                        @error('tgl_order')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-5">
                                        <label for="edit_jam_order"
                                            class="form-label fw-bold h5 text-dark">Jam</label>
                                        <input type="time" id="edit_jam_order" name="jam_order"
                                            class="form-control @error('jam_order') is-invalid @enderror"
                                            value="{{ old('jam_order') }}" required>
                                        @error('jam_order')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </x-content-card>

                            <x-content-card>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label fw-bold h5 text-dark">Cito?</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input @error('cyto') is-invalid @enderror"
                                                        type="radio" name="cyto" value="1"
                                                        id="edit_cyto_yes" @checked(old('cyto') == 1) required>
                                                    <label class="form-check-label" for="edit_cyto_yes">Ya</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('cyto') is-invalid @enderror"
                                                            type="radio" name="cyto" value="0"
                                                            id="edit_cyto_no" @checked(old('cyto') == 0) required>
                                                        <label class="form-check-label"
                                                            for="edit_cyto_no">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @error('cyto')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </x-content-card>

                            <x-content-card>
                                <h6 class="fw-bold">Jadwal Pemeriksaan</h6>
                                <p class="text-muted">
                                    Tanggal ini diisi jika pemeriksaan radiologi dijadwalkan bukan pada hari ini.
                                </p>
                                <div class="row">
                                    <div class="col-7">
                                        <label for="edit_tgl_pemeriksaan"
                                            class="form-label fw-bold h5 text-dark">Tanggal:</label>
                                        <input type="date" id="edit_tgl_pemeriksaan" name="tgl_pemeriksaan"
                                            class="form-control" value="{{ old('tgl_pemeriksaan') }}">
                                    </div>

                                    <div class="col-5">
                                        <label for="edit_jam_pemeriksaan"
                                            class="form-label fw-bold h5 text-dark">Jam:</label>
                                        <input type="time" id="edit_jam_pemeriksaan" name="jam_pemeriksaan"
                                            class="form-control" value="{{ old('jam_pemeriksaan') }}">
                                    </div>
                                </div>
                            </x-content-card>

                            <x-content-card>
                                <h6 class="fw-bold">Catatan Klinis/Diagnosis</h6>
                                <textarea class="form-control" id="edit_diagnosis" name="diagnosis">{{ old('diagnosis') }}</textarea>
                            </x-content-card>
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-12">
                                    <x-content-card>
                                        <div class="dropdown">
                                            <input type="text" class="form-control" id="editSearchInput"
                                                placeholder="Cari produk..." autocomplete="off">
                                            <ul class="dropdown-menu w-100 d-none" id="editDataList"
                                                aria-labelledby="editSearchInput"></ul>
                                        </div>
                                    </x-content-card>
                                </div>

                                <div class="col-12">
                                    <x-content-card>
                                        <h6 class="fw-bold">Daftar Order Pemeriksaan</h6>
                                        <ul id="editOrderList" class="list-group"></ul>
                                    </x-content-card>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> {{-- /modal-body --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===================== SHOW MODAL ===================== --}}
<div class="modal fade" id="showRadiologiModal" tabindex="-1" aria-labelledby="showRadiologiModalLabel"
    aria-hidden="true" dir="ltr">
    <div class="modal-dialog modal-xl text-start">
        <div class="modal-content text-start">

            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="showRadiologiModalLabel">
                    Detail Pemeriksaan Radiologi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <x-content-card>
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
                        </x-content-card>

                        <x-content-card>
                            <div class="row">
                                <div class="col-6">
                                    <p class="p-0 m-0"><strong>Cito :</strong> <span id="cyto"></span></p>
                                </div>
                            </div>
                        </x-content-card>

                        <x-content-card>
                            <div class="row">
                                <div class="col-12">
                                    <p class="p-0 m-0"><strong>Jadwal Pemeriksaan :</strong></p>
                                    <p class="p-0 m-0" id="jadwal_pemeriksaan"></p>
                                </div>
                            </div>
                        </x-content-card>

                        <x-content-card>
                            <div class="row">
                                <div class="col-12">
                                    <p class="p-0 m-0"><strong>Catatan Klinis/Diagnosis :</strong></p>
                                    <p class="p-0 m-0" id="diagnosis">Tidak ada diagnosis</p>
                                </div>
                            </div>
                        </x-content-card>
                    </div>

                    <div class="col-md-4">
                        <x-content-card>
                            <h6 class="fw-bold">Daftar Pemeriksaan</h6>
                            <ul id="showOrderList" class="list-group"></ul>
                        </x-content-card>
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
        (function() {
            const debounce = (fn, d = 500) => {
                let t;
                return (...a) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn(...a), d);
                };
            };

            const produk = @json($produk);

            const setupSearch = (rootSel, ids) => {
                const $root = $(rootSel);
                const $search = $root.find(ids.search);
                const $menu = $root.find(ids.menu);
                const $list = $root.find(ids.list);
                if (!$search.length || !$menu.length) return;

                const render = (items) => {
                    const html = items.map(i =>
                        `<a class="dropdown-item" href="#" data-kd-produk="${i.kp_produk}">${i.deskripsi}</a>`
                    ).join('');
                    $menu.html(html).removeClass('d-none').addClass('show');
                };

                const filter = (kw) =>
                    produk.filter(p => (p.deskripsi || '').toLowerCase().includes((kw || '').toLowerCase()));

                $search.on('focus', () => render(produk));

                $search.on('keyup', debounce(() => {
                    render(filter($search.val()));
                }));

                $menu.on('click', '.dropdown-item', (e) => {
                    e.preventDefault();
                    const $a = $(e.currentTarget);
                    const text = $a.text();
                    const kd = $a.data('kd-produk');

                    const li = `
                        <li class="list-group-item d-flex align-items-center">
                            <span class="flex-grow-1 text-start">${text}</span>
                            <input type="hidden" name="kd_produk[]" value="${kd}">
                            <button type="button" class="btn btn-link text-danger p-0 ms-2 remove-item" aria-label="Hapus">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </li>`;
                    $list.append(li);

                    $search.val('');
                    $menu.addClass('d-none').removeClass('show');
                });

                $list.on('click', '.remove-item', (e) => {
                    e.preventDefault();
                    $(e.currentTarget).closest('.list-group-item').remove();
                });

                // Tutup menu saat klik di luar dropdown
                $(document).on('click', (evt) => {
                    if (!$(evt.target).closest($root.find('.dropdown')).length && evt.target !== $search[
                            0]) {
                        $menu.addClass('d-none').removeClass('show');
                    }
                });

                // Saat modal muncul, pastikan menu tertutup
                $root.on('shown.bs.modal', () => {
                    $menu.addClass('d-none').removeClass('show');
                });
            };

            // Inisialisasi untuk ADD & EDIT
            setupSearch('#addRadiologiModal', {
                search: '#searchInput',
                menu: '#dataList',
                list: '#orderList'
            });
            setupSearch('#editRadiologiModal', {
                search: '#editSearchInput',
                menu: '#editDataList',
                list: '#editOrderList'
            });

            // SHOW modal tidak butuh search (cukup manipulasi #showOrderList via server/JS lain kalau perlu)
        })();
    </script>
@endpush
