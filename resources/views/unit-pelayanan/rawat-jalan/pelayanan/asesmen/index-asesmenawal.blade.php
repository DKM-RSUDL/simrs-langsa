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
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="Cari" aria-label="Cari" aria-describedby="basic-addon1" id="searchInput">
            </div>
        </div>

        <!-- Button "Tambah" di sebelah kanan -->
        <div class="col-md-2 text-end ms-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailPasienModal" type="button">
                <i class="ti-plus"></i> Tambah
            </button>
        </div>
    </div>
</div>

<ul class="list-group" id="asesmenList">
    @foreach ($asesmen as $item)
        <li class="list-group-item d-flex justify-content-between align-items-center"
            data-name="{{ $item->user->name }}">
            <div class="d-flex align-items-center">
                <img src="{{ asset('assets/images/avatar1.png') }}" class="rounded-circle me-3" alt="Foto Pasien" width="70" height="70">
                <div>
                    <span class="text-primary fw-bold">Asesmen Medis-Pasien Umum/Dewasa</span> <br>
                    By: <span class="fw-bold">{{ $item->user->name }}</span>
                </div>
            </div>
            <div>
                <button type="button" onclick="showAsesmen('{{ $item->id }}')"
                    data-url="{{ url('unit-pelayanan/rawat-jalan/unit/' . $dataMedis->kd_unit . '/pelayanan/' . $dataMedis->kd_pasien . '/' . \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d') . '/' . $dataMedis->urut_masuk . '/asesmen/' . $item->id) }}"
                    class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i> Lihat
                </button>
                @include('unit-pelayanan.rawat-jalan.pelayanan.asesmen.show')
                <button type="button" onclick="editAsesmen('{{ $item->id }}')"
                    data-url="{{ url('unit-pelayanan/rawat-jalan/unit/' . $dataMedis->kd_unit . '/pelayanan/' . $dataMedis->kd_pasien .'/' . \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d') . '/' . $dataMedis->urut_masuk . '/asesmen/' . $item->id) }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </button>
                @include('unit-pelayanan.rawat-jalan.pelayanan.asesmen.edit')
            </div>
        </li>
    @endforeach
</ul>
@include('unit-pelayanan.rawat-jalan.pelayanan.asesmen.create-asesmen')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get all filter elements
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const searchInput = document.getElementById('searchInput');
        const asesmenList = document.getElementById('asesmenList');

        // Add event listeners to filter inputs
        startDateInput.addEventListener('input', filterList);
        endDateInput.addEventListener('input', filterList);
        searchInput.addEventListener('input', filterList);

        function filterList() {
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;
            const search = searchInput.value.toLowerCase();

            // Loop through all items and filter based on criteria
            Array.from(asesmenList.children).forEach(item => {
                const itemDate = item.getAttribute('data-date');
                const itemName = item.getAttribute('data-name').toLowerCase();

                const dateMatch = (!startDate || itemDate >= startDate) && (!endDate || itemDate <= endDate);
                const searchMatch = itemName.includes(search);

                if (dateMatch && searchMatch) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    });
</script>
