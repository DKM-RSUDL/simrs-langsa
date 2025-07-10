@push('css')
    <style>
        #asesmenList .list-group-item:nth-child(even) {
            background-color: #edf7ff;
        }

        #asesmenList .list-group-item:nth-child(odd) {
            background-color: #ffffff;
        }

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

        /* Bootstrap Dropdown Styling */
        .dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #dee2e6;
            padding: 0.5rem 0;
        }

        .dropdown-item {
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
            border: none;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #495057;
            padding-left: 1.75rem;
        }

        .dropdown-item:focus {
            background-color: #e9ecef;
            color: #495057;
        }

        .dropdown-item i {
            width: 18px;
            color: #6c757d;
        }

        .dropdown-header {
            padding: 0.5rem 1.5rem 0.25rem 1.5rem;
            margin-bottom: 0.25rem;
            font-size: 0.8rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #6c757d;
            display: flex;
            align-items: center;
        }

        .dropdown-header i {
            width: 18px;
            color: #6c757d;
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            border-top: 1px solid #dee2e6;
        }

        .dropdown-toggle::after {
            margin-left: 0.5rem;
            transition: transform 0.2s ease;
        }

        .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }

        /* Hover effect untuk button dropdown */
        .dropdown-toggle:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Animation untuk dropdown */
        .dropdown-menu.show {
            animation: fadeInDown 0.2s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

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
        <!-- Button "Tambah" dengan Bootstrap Dropdown -->
        <div class="col-md-3 text-end ms-auto">

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailPasienModal" type="button">
                <i class="ti-plus"></i> Tambah
            </button>
            @php
                $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));
            @endphp

            <div class="dropdown mt-2">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus me-2"></i>Tambah Asesmen
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @canany(['is-admin', 'is-perawat', 'is-bidan'])
                        <li>
                            <h6 class="dropdown-header"><i class="fas fa-user-nurse me-2"></i>Asesmen Keperawatan</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('rawat-jalan.asesmen-keperawatan.index', ['kd_unit' => request()->route('kd_unit'),'kd_pasien' => request()->route('kd_pasien'), 'tgl_masuk' => request()->route('tgl_masuk'), 'urut_masuk' => request()->route('urut_masuk')]) }}">
                                <i class="fas fa-user-nurse me-2"></i>Keperawatan
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href=""></i>Anak
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="">
                                <i class="fas fa-baby me-2"></i>Perinatology
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="">
                                <i class="fas fa-eye me-2"></i>Mata/Oftalmologi
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="">
                                <i class="fas fa-heart me-2"></i>Terminal
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @endcanany

                    <li>
                        <h6 class="dropdown-header"><i class="fas fa-stethoscope me-2"></i>Asesmen Medis</h6>
                    </li>
                    <li>
                        <a class="dropdown-item" href="">
                            <i class="fas fa-female me-2"></i>Obstetri/Maternitas
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="">
                            <i class="fas fa-walking me-2"></i>Geriatri
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="">
                            <i class="fas fa-stethoscope me-2"></i>THT
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('rawat-jalan.asesmen.medis.paru.index', ['kd_unit' => request()->route('kd_unit'),'kd_pasien' => request()->route('kd_pasien'), 'tgl_masuk' => request()->route('tgl_masuk'), 'urut_masuk' => request()->route('urut_masuk')]) }}">
                            <i class="fas fa-lungs me-2"></i>Paru
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="">
                            <i class="fas fa-brain me-2"></i>Neurologi
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="">
                            <i class="fas fa-hand-paper me-2"></i>Kulit dan Kelamin
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('rawat-jalan.asesmen.medis.ginekologik.index', ['kd_unit' => request()->route('kd_unit'),'kd_pasien' => request()->route('kd_pasien'), 'tgl_masuk' => request()->route('tgl_masuk'), 'urut_masuk' => request()->route('urut_masuk')]) }}">
                            <i class="fas fa-venus me-2"></i>Ginekologik
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{">
                            <i class="fas fa-user-md me-2"></i>Psikiatri
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<ul class="list-group" id="asesmenList">
    {{-- {{ $asesmen }} --}}
    @foreach ($asesmen as $item)
        <li class="list-group-item d-flex justify-content-between align-items-center"
            data-name="{{ $item->user->name }}">
            <div class="d-flex align-items-center">
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
            <div>
                @if ($item->kategori == 1 && $item->sub_kategori == 1)
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

                @elseif($item->kategori == 2 && $item->sub_kategori == 1)
                    <button type="button"
                        onclick="showAsesmenKeperawatanJalan('{{ $item->id }}', '{{ $dataMedis->kd_unit }}', '{{ $dataMedis->kd_pasien }}', '{{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d') }}', '{{ $dataMedis->urut_masuk }}')"
                        class="btn btn-info btn-sm px-3">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </button>

                        <a href="{{ route('rawat-jalan.asesmen-keperawatan.edit', [
                            'kd_unit' => $dataMedis->kd_unit,
                            'kd_pasien' => $dataMedis->kd_pasien,
                            'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'),
                            'urut_masuk' => $dataMedis->urut_masuk,
                            'id' => $item->id
                        ]) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                @endif

                @if ($item->kategori == 1 && $item->sub_kategori == 8)
                    <a href="{{ route('rawat-jalan.asesmen.medis.paru.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>

                    <a href="{{ route('rawat-jalan.asesmen.medis.paru.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 1 && $item->sub_kategori == 9)
                    <a href="{{ route('rawat-jalan.asesmen.medis.ginekologik.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>

                    <a href="{{ route('rawat-jalan.asesmen.medis.ginekologik.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif
            </div>
        </li>
    @endforeach
</ul>
@include('unit-pelayanan.rawat-jalan.pelayanan.asesmen.create-asesmen')
@include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-keperawatan.show')

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get all filter elements
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const searchInput = document.getElementById('searchInput');
            const selectEpisode = document.getElementById('SelectEpisode');
            const asesmenList = document.getElementById('asesmenList');

            // Add event listeners to filter inputs
            startDateInput.addEventListener('input', filterList);
            endDateInput.addEventListener('input', filterList);
            searchInput.addEventListener('input', filterList);
            selectEpisode.addEventListener('change', filterList);

            function filterList() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                const search = searchInput.value.toLowerCase();
                const selectedEpisode = selectEpisode.value;

                // Loop through all items and filter based on criteria
                Array.from(asesmenList.children).forEach(item => {
                    const itemDate = item.getAttribute('data-date');
                    const itemName = item.getAttribute('data-name').toLowerCase();

                    const dateMatch = (!startDate || itemDate >= startDate) && (!endDate || itemDate <= endDate);
                    const searchMatch = itemName.includes(search);

                    // Filter berdasarkan episode jika bukan "semua"
                    let episodeMatch = true;
                    if (selectedEpisode !== 'semua') {
                        // Implementasi filter episode sesuai kebutuhan
                        // Contoh: bisa berdasarkan tanggal atau data lain
                        episodeMatch = true; // Sesuaikan logic sesuai kebutuhan
                    }

                    if (dateMatch && searchMatch && episodeMatch) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            // Optional: Add smooth scroll untuk dropdown items yang panjang
            const dropdownMenu = document.querySelector('.dropdown-menu');
            if (dropdownMenu) {
                dropdownMenu.addEventListener('scroll', function () {
                    // Handle scroll events jika diperlukan
                });
            }

            // Optional: Close dropdown saat mengklik item (untuk mobile)
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function () {
                    // Close dropdown after selection (optional)
                    const dropdown = bootstrap.Dropdown.getInstance(document.getElementById('dropdownMenuButton'));
                    if (dropdown) {
                        dropdown.hide();
                    }
                });
            });
        });

        // Optional: Function untuk handle loading state
        function showLoadingState(button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
            button.disabled = true;

            // Restore button after some time (contoh)
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
        }
    </script>
@endpush
