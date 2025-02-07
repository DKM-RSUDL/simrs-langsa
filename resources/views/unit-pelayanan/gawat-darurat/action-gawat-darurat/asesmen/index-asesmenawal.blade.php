<div class="d-flex justify-content-start align-items-center m-3">
    <div class="row g-3 w-100">
        <!-- Select Episode Option -->
        <div class="col-md-2">
            <select class="form-select" id="SelectEpisode" aria-label="Pilih...">
                <option value="semua" selected>Semua Episode</option>
                <option value="Episode1">Episode Sekarang</option>
                <option value="Episode2">1 Bulan</option>
                <option value="Episode3">3 Bulan</option>
                <option value="Episode4">6 Bulan</option>
                <option value="Episode5">9 Bulan</option>
            </select>
        </div>

        <!-- Start Date -->
        <div class="col-md-2">
            <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Dari Tanggal">
        </div>

        <!-- End Date -->
        <div class="col-md-2">
            <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
        </div>

        <!-- Search Bar -->
        <div class="col-md-2">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="Cari" aria-label="Cari"
                    aria-describedby="basic-addon1" id="searchInput">
            </div>
        </div>

        <!-- Button "Tambah" di sebelah kanan -->
        <div class="col-md-4 text-end ms-auto">
            @canany(['is-admin', 'is-dokter-umum', 'is-dokter-spesialis'])
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailPasienModal" type="button">
                    <i class="ti-plus"></i> Tambah
                </button>
            @endcanany

            @canany(['is-admin', 'is-perawat', 'is-bidan'])
                <a href="{{ route('asesmen-keperawatan.index', ['kd_pasien' => request()->route('kd_pasien'), 'tgl_masuk' => request()->route('tgl_masuk')]) }}"
                    class="btn btn-primary">
                    <i class="ti-plus"></i> Keperawatan
                @endcanany
            </a>
        </div>
    </div>
</div>

<ul class="list-group" id="asesmenList">
    @foreach ($asesmen as $item)
        <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $item->id }}"
            data-date="{{ \Carbon\Carbon::parse($item->waktu_asesmen)->format('Y-m-d') }}"
            data-name="{{ $item->user->name }}">

            <div class="d-flex align-items-center gap-4">
                <!-- Tanggal -->
                <div class="text-center px-3">
                    <div class="fw-bold fs-4 mb-0 text-primary">
                        {{ \Carbon\Carbon::parse($item->waktu_asesmen)->format('d') }}
                    </div>
                    <div class="text-muted" style="font-size: 0.85rem;">
                        {{ \Carbon\Carbon::parse($item->waktu_asesmen)->format('M-y') }}
                    </div>
                    <div class="text-muted" style="font-size: 0.85rem;">
                        {{ \Carbon\Carbon::parse($item->waktu_asesmen)->format('H:i') }}
                    </div>
                </div>

                <!-- Avatar dan Info -->
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset('assets/images/avatar1.png') }}" class="rounded-circle border border-2"
                        alt="Foto Pasien" width="60" height="60">
                    <div>
                        <div class="text-primary fw-bold mb-1">
                            Asesmen {{ getKategoriAsesmen($item->kategori, $item->sub_kategori) }}
                        </div>
                        <div class="text-muted">
                            By: <span class="fw-semibold">{{ $item->user->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2">
                @if ($item->kategori == 1)
                    <button type="button" onclick="showAsesmen('{{ $item->id }}')"
                        data-url="{{ url('unit-pelayanan/gawat-darurat/pelayanan/' . $dataMedis->kd_pasien . '/' . \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d') . '/asesmen/' . $item->id) }}"
                        class="btn btn-info btn-sm px-3">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </button>
                    <button type="button" onclick="editAsesmen('{{ $item->id }}')"
                        data-url="{{ url('unit-pelayanan/gawat-darurat/pelayanan/' . $dataMedis->kd_pasien . '/' . \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d') . '/asesmen/' . $item->id) }}"
                        class="btn btn-secondary btn-sm px-3">
                        <i class="fas fa-edit me-1"></i> Edit
                    </button>
                @elseif($item->kategori == 2)
                    <button type="button"
                        onclick="showAsesmenKeperawatan('{{ $item->id }}', '{{ $dataMedis->kd_pasien }}', '{{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d') }}')"
                        class="btn btn-info btn-sm px-3">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </button>
                    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.show')

                    <a href="{{ route('asesmen-keperawatan.edit', [
                        'kd_pasien' => $dataMedis->kd_pasien,
                        'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'),
                        'id' => $item->id
                    ]) }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    {{-- @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.edit') --}}
                @endif
            </div>
        </li>
    @endforeach
</ul>


@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.show')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.edit')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.show')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.edit')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.create-asesmen')

<style>
    #asesmenList .list-group-item:nth-child(even) {
        background-color: #edf7ff;
    }

    /* Background putih untuk item ganjil */
    #asesmenList .list-group-item:nth-child(odd) {
        background-color: #ffffff;
    }

    /* Efek hover tetap sama untuk konsistensi */
    #asesmenList .list-group-item:hover {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .list-group-item {
        margin-bottom: 0.2rem;
        border-radius: 0.5rem !important;
        padding: 0.5rem;
        border: 1px solid #dee2e6;
        background: white;
        transition: all 0.2s;
    }

    .list-group-item:hover {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .gap-2 {
        gap: 0.5rem !important;
    }

    .gap-3 {
        gap: 1rem !important;
    }

    .gap-4 {
        gap: 1.5rem !important;
    }

    .btn-sm {
        padding: 0.4rem 1rem;
        font-size: 0.875rem;
    }

    .btn i {
        font-size: 0.875rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get elements
        const selectEpisode = document.getElementById('SelectEpisode');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const searchInput = document.getElementById('searchInput');
        const asesmenList = document.getElementById('asesmenList');

        function filterList() {

            const startDate = startDateInput.value;
            const endDate = endDateInput.value;
            const search = searchInput.value.toLowerCase().trim();
            const episodeValue = selectEpisode.value;

            // Debug values
            console.log({
                startDate,
                endDate,
                search,
                episodeValue
            });

            const items = asesmenList.getElementsByTagName('li');
            console.log('Total items:', items.length);

            Array.from(items).forEach(item => {
                const itemDate = item.getAttribute('data-date');
                const itemName = item.getAttribute('data-name').toLowerCase();

                let show = true;

                // Date filter
                if (startDate && itemDate) {
                    show = show && (itemDate >= startDate);
                }

                if (endDate && itemDate) {
                    show = show && (itemDate <= endDate);
                }

                // Search filter
                if (search) {
                    show = show && itemName.includes(search);
                }

                // Episode filter
                if (episodeValue !== 'semua' && itemDate) {
                    const currentDate = new Date();
                    const itemDateTime = new Date(itemDate);
                    const monthDiff = Math.floor(
                        (currentDate - itemDateTime) / (1000 * 60 * 60 * 24 * 30)
                    );


                    switch (episodeValue) {
                        case 'Episode1': // Bulan ini
                            show = show && (monthDiff === 0);
                            break;
                        case 'Episode2': // 1 bulan
                            show = show && (monthDiff <= 1);
                            break;
                        case 'Episode3': // 3 bulan
                            show = show && (monthDiff <= 3);
                            break;
                        case 'Episode4': // 6 bulan
                            show = show && (monthDiff <= 6);
                            break;
                        case 'Episode5': // 9 bulan
                            show = show && (monthDiff <= 9);
                            break;
                    }
                }

                // Menggunakan d-flex untuk menampilkan dan d-none untuk menyembunyikan
                if (show) {
                    item.classList.remove('d-none');
                    item.classList.add('d-flex');
                } else {
                    item.classList.remove('d-flex');
                    item.classList.add('d-none');
                }
            });
        }

        // Add event listeners
        selectEpisode.addEventListener('change', filterList);
        startDateInput.addEventListener('input', filterList);
        endDateInput.addEventListener('input', filterList);
        searchInput.addEventListener('input', filterList);

        // Run initial filter
        filterList();
    });
</script>
