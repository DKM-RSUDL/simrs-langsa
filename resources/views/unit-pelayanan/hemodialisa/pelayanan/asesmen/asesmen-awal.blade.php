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
        <div class="col-md-3 text-end ms-auto">
            <div class="custom__dropdown">
                <button class="custom__dropdown__btn" onclick="toggleDropdown(this)">
                    Tambah
                </button>
                <ul class="custom__dropdown__menu">
                    <li>
                        <a class="custom__dropdown__item" href="{{ route('hemodialisa.pelayanan.asesmen.medis.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                            Asesmen Medis
                        </a>
                    </li>
                    <li>
                        <a class="custom__dropdown__item" href="{{ route('hemodialisa.pelayanan.asesmen.keperawatan.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                            Asesmen Keperawatan
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<ul class="list-group" id="asesmenList">
    @foreach ($asesmen as $item)
        <li class="list-group-item d-flex justify-content-between align-items-center">

            <div class="d-flex align-items-center gap-4">
                <div class="text-center px-3">
                    <div class="fw-bold fs-4 mb-0 text-primary">
                        {{ date('d', strtotime($item->waktu_asesmen)) }}
                    </div>
                    <div class="text-muted" style="font-size: 0.85rem;">
                        {{ date('M-y', strtotime($item->waktu_asesmen)) }}
                    </div>
                    <div class="text-muted" style="font-size: 0.85rem;">
                        {{ date('H:i', strtotime($item->waktu_asesmen)) }}
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset('assets/images/avatar1.png') }}" class="rounded-circle me-3" alt="Foto Pasien"
                        width="70" height="70">
                    <div>
                        <div class="text-primary fw-bold mb-1">
                            @php
                                $label = 'Asesmen';

                                if($item->kategori == 1) $label .= ' Medis';
                                if($item->kategori == 2) $label .= ' Keperawatan';
                            @endphp

                            {{ $label }}
                        </div>
                        <div class="text-muted">
                            {{-- By: {{ $item->userCreate->karyawan->gelar_depan . ' ' . str()->title($item->userCreate->karyawan->nama) . ' ' . $item->userCreate->karyawan->gelar_belakang }} --}}
                            By: {{ $item->userCreate->karyawan->gelar_depan ?? '' }} {{ $item->userCreate->karyawan ? str()->title($item->userCreate->karyawan->nama) : '' }} {{ $item->userCreate->karyawan->gelar_belakang ?? '' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2">
                @if ($item->kategori == 1)
                    <a href="{{ route('hemodialisa.pelayanan.asesmen.medis.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i>
                        Lihat
                    </a>

                    <a href="{{ route('hemodialisa.pelayanan.asesmen.medis.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                @endif


                @if ($item->kategori == 2)
                    <a href="{{ route('hemodialisa.pelayanan.asesmen.keperawatan.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i>
                        Lihat
                    </a>

                    <a href="{{ route('hemodialisa.pelayanan.asesmen.keperawatan.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                @endif
            </div>
        </li>
    @endforeach
</ul>

@push('js')
    <script>
        // untuk dropdown:
        function toggleDropdown(button) {
            const menu = button.nextElementSibling;
            button.classList.toggle('active');
            menu.classList.toggle('show');

            // Close dropdown when clicking outside
            document.addEventListener('click', function closeDropdown(e) {
                if (!button.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.remove('show');
                    button.classList.remove('active');
                    document.removeEventListener('click', closeDropdown);
                }
            });
        }
    </script>
@endpush
