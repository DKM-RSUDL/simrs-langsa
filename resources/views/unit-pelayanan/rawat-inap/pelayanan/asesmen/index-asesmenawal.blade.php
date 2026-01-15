<div class="d-flex justify-content-start align-items-center">
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
        <div class="col-md-4 text-end ms-auto" style="margin-right: -15px;">
            @php
                $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));
            @endphp
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus me-2"></i>Tambah Asesmen
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    @canany(['is-admin', 'is-perawat', 'is-bidan'])
                        <li class="bg-light">
                            <h6 class="dropdown-header"><i class="fas fa-user-nurse me-2"></i>Asesmen Keperawatan</h6>
                        </li>
                        <li><a class="custom__dropdown__item"
                                href="{{ route('rawat-inap.asesmen.keperawatan.umum.create', [
                                    'kd_unit' => request()->route('kd_unit'),
                                    'kd_pasien' => request()->route('kd_pasien'),
                                    'tgl_masuk' => request()->route('tgl_masuk'),
                                    'urut_masuk' => request()->route('urut_masuk'),
                                ]) }}">Umum/Dewasa</a>
                        </li>
                        <li><a class="custom__dropdown__item"
                                href="{{ route('rawat-inap.asesmen.keperawatan.anak.index', [
                                    'kd_unit' => request()->route('kd_unit'),
                                    'kd_pasien' => request()->route('kd_pasien'),
                                    'tgl_masuk' => request()->route('tgl_masuk'),
                                    'urut_masuk' => request()->route('urut_masuk'),
                                ]) }}">Anak</a>
                        </li>
                        <li><a class="custom__dropdown__item"
                                href="{{ route('rawat-inap.asesmen.keperawatan.perinatology.index', [
                                    'kd_unit' => request()->route('kd_unit'),
                                    'kd_pasien' => request()->route('kd_pasien'),
                                    'tgl_masuk' => request()->route('tgl_masuk'),
                                    'urut_masuk' => request()->route('urut_masuk'),
                                ]) }}">Perinatology</a>
                        </li>
                        <li><a class="custom__dropdown__item"
                                href="{{ route('rawat-inap.asesmen.keperawatan.terminal.index', [
                                    'kd_unit' => request()->route('kd_unit'),
                                    'kd_pasien' => request()->route('kd_pasien'),
                                    'tgl_masuk' => request()->route('tgl_masuk'),
                                    'urut_masuk' => request()->route('urut_masuk'),
                                ]) }}">Terminal</a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @endcanany


                    <li class="bg-light">
                        <h6 class="dropdown-header"><i class="fas fa-stethoscope me-2"></i>Asesmen Medis</h6>
                    </li>
                    {{-- <li><a class="custom__dropdown__item" href="#" data-bs-toggle="modal"
                            data-bs-target="#detailPasienModal">Medis Umum/Dewasa</a></li> --}}

                    <li><a class="custom__dropdown__item"
                            href="{{ route('rawat-inap.asesmen.medis.pengkajian-awal-medis.index', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}">Awal
                            Medis</a>
                    </li>
                    <li><a class="custom__dropdown__item"
                            href="{{ route('rawat-inap.asesmen.keperawatan.opthamology.index', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}">Mata/Opthamologi</a>
                    </li>
                    <li><a class="custom__dropdown__item"
                            href="{{ route('rawat-inap.asesmen.medis.medis-anak.index', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}">Anak</a>
                    </li>
                    <li><a class="custom__dropdown__item"
                            href="{{ route('rawat-inap.asesmen.medis.obstetri-maternitas.index', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}">Obstetri</a>
                    </li>
                    <li><a class="custom__dropdown__item"
                            href="{{ route('rawat-inap.asesmen.medis.tht.index', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}">THT</a>
                    </li>
                    <li><a class="custom__dropdown__item"
                            href="{{ route('rawat-inap.asesmen.medis.paru.index', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}">Paru</a>
                    </li>
                    <li><a class="custom__dropdown__item"
                            href="{{ route('rawat-inap.asesmen.medis.neurologi.index', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}">Neurologi</a>
                    </li>
                    <li><a class="custom__dropdown__item"
                            href="{{ route('rawat-inap.asesmen.medis.kulit-kelamin.index', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}">Kulit
                            dan Kelamin</a></li>

                    <li><a class="custom__dropdown__item"
                            href="{{ route('rawat-inap.asesmen.medis.ginekologik.index', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}">Ginekologik</a>
                    </li>
                    <li><a class="custom__dropdown__item"
                            href="{{ route('rawat-inap.asesmen.medis.psikiatri.index', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}">Psikiatri</a>
                    </li>
                    <li><a class="custom__dropdown__item"
                            href="{{ route('rawat-inap.asesmen.medis.geriatri.index', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}">Geriatri</a>
                    </li>
                    <li><a class="custom__dropdown__item"
                            href="{{ route('rawat-inap.asesmen.medis.medis-neonatologi.index', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                            ]) }}">Neonatologi</a>
                    </li>
                </ul>
            </div>

            {{-- @canany(['is-admin', 'is-dokter-umum', 'is-dokter-spesialis'])
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailPasienModal" type="button">
                <i class="ti-plus"></i> Tambah
            </button>
            @endcanany

            @canany(['is-admin', 'is-perawat', 'is-bidan'])
            <a href="{{ route('rawat-inap.asesmen-anak.index', [
                    'kd_unit' => request()->route('kd_unit'),
                    'kd_pasien' => request()->route('kd_pasien'),
                    'tgl_masuk' => request()->route('tgl_masuk'),
                    'urut_masuk' => request()->route('urut_masuk'),
                ]) }}" class="btn btn-primary">
                <i class="ti-plus"></i> Asesmen Anak
            </a>
            @endcanany --}}
        </div>
    </div>
</div>

<ul class="list-group" id="asesmenList">
    @foreach ($asesmen as $item)
        <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $item->id }}"
            data-date="{{ \Carbon\Carbon::parse($item->waktu_asesmen)->format('Y-m-d') }}"
            data-name="{{ $item->user->name ?? '' }}">

            <div class="d-flex align-items-center gap-4">

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

                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset('assets/images/avatar1.png') }}" class="rounded-circle me-3" alt="Foto Pasien"
                        width="70" height="70">
                    <div>
                        <div class="text-primary fw-bold mb-1">
                            Asesmen {{ getKategoriAsesmen($item->kategori, $item->sub_kategori) }}
                        </div>
                        <div class="text-muted">
                            By: <span class="fw-semibold">{{ $item->user->name ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2">
                @if ($item->kategori == 1 && $item->sub_kategori == 5)
                    <a href="{{ route('rawat-inap.asesmen.medis.tht.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>
                    <a id="btnPrintAsesmen"
                        href="{{ route('rawat-inap.asesmen.medis.tht.print', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </a>
                    <a href="{{ route('rawat-inap.asesmen.medis.tht.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 1 && $item->sub_kategori == 8)
                    <a href="{{ route('rawat-inap.asesmen.medis.paru.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>

                    <a id="btnPrintAsesmen"
                        href="{{ route('rawat-inap.asesmen.medis.paru.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </a>

                    <a href="{{ route('rawat-inap.asesmen.medis.paru.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 1 && $item->sub_kategori == 9)
                    <a href="{{ route('rawat-inap.asesmen.medis.ginekologik.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>
                    <a id="btnPrintAsesmen"
                        href="{{ route('rawat-inap.asesmen.medis.ginekologik.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </a>
                    <a href="{{ route('rawat-inap.asesmen.medis.ginekologik.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 2 && $item->sub_kategori == 13)
                    <a href="{{ route('rawat-inap.asesmen.keperawatan.terminal.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>

                    <a href="{{ route('rawat-inap.asesmen.keperawatan.terminal.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 2 && $item->sub_kategori == 7)
                    <a href="{{ route('rawat-inap.asesmen.keperawatan.anak.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>

                    <a href="{{ route('rawat-inap.asesmen.keperawatan.anak.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 1 && $item->sub_kategori == 6)
                    <a href="{{ route('rawat-inap.asesmen.keperawatan.opthamology.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>
                    <a id="btnPrintAsesmen"
                        href="{{ route('rawat-inap.asesmen.keperawatan.opthamology.print', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </a>

                    <a href="{{ route('rawat-inap.asesmen.keperawatan.opthamology.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 2 && $item->sub_kategori == 2)
                    <a href="{{ route('rawat-inap.asesmen.keperawatan.perinatology.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>

                    <a href="{{ route('rawat-inap.asesmen.keperawatan.perinatology.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 1 && $item->sub_kategori == 10)
                    <a href="{{ route('rawat-inap.asesmen.medis.kulit-kelamin.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>

                    <a id="btnPrintAsesmen"
                        href="{{ route('rawat-inap.asesmen.medis.kulit-kelamin.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </a>

                    <a href="{{ route('rawat-inap.asesmen.medis.kulit-kelamin.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 1 && $item->sub_kategori == 11)
                    <a href="{{ route('rawat-inap.asesmen.medis.psikiatri.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>
                    <a id="btnPrintAsesmen"
                        href="{{ route('rawat-inap.asesmen.medis.psikiatri.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </a>

                    <a href="{{ route('rawat-inap.asesmen.medis.psikiatri.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 1 && $item->sub_kategori == 12)
                    <a href="{{ route('rawat-inap.asesmen.medis.geriatri.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>

                    <a href="{{ route('rawat-inap.asesmen.medis.geriatri.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                <!-- perbaiki -->
                @if ($item->kategori == 1 && $item->sub_kategori == 1)
                    <a href="{{ route('rawat-inap.asesmen.medis.pengkajian-awal-medis.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>
                    <a id="btnPrintAsesmen"
                        href="{{ route('rawat-inap.asesmen.medis.pengkajian-awal-medis.print', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </a>
                    <a href="{{ route('rawat-inap.asesmen.medis.pengkajian-awal-medis.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 1 && $item->sub_kategori == 7)
                    <a href="{{ route('rawat-inap.asesmen.medis.medis-anak.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>
                    <a id="btnPrintAsesmen"
                        href="{{ route('rawat-inap.asesmen.medis.medis-anak.print', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </a>
                    <a href="{{ route('rawat-inap.asesmen.medis.medis-anak.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 1 && $item->sub_kategori == 14)
                    <a href="{{ route('rawat-inap.asesmen.medis.medis-neonatologi.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>

                    <a href="{{ route('rawat-inap.asesmen.medis.medis-neonatologi.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 2 && $item->sub_kategori == 1)
                    <a href="{{ route('rawat-inap.asesmen.keperawatan.umum.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>

                    <a href="{{ route('rawat-inap.asesmen.keperawatan.umum.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @if ($item->kategori == 1 && $item->sub_kategori == 4)
                    <a href="{{ route('rawat-inap.asesmen.medis.obstetri-maternitas.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>

                    <a href="{{ route('rawat-inap.asesmen.medis.obstetri-maternitas.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </a>

                    <a href="{{ route('rawat-inap.asesmen.medis.obstetri-maternitas.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @elseif($item->kategori == 1 && $item->sub_kategori == 3)
                    <a href="{{ route('rawat-inap.asesmen.medis.neurologi.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>
                    <a id="btnPrintAsesmen"
                        href="{{ route('rawat-inap.asesmen.medis.neurologi.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </a>
                    <a href="{{ route('rawat-inap.asesmen.medis.neurologi.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                        class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif
            </div>
        </li>
    @endforeach

    {{-- ASESMEN IGD --}}
    @foreach ($asesmenIGD as $itemIGD)
        <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $itemIGD->id }}"
            data-date="{{ \Carbon\Carbon::parse($itemIGD->waktu_asesmen)->format('Y-m-d') }}"
            data-name="{{ $itemIGD->user->name }}">

            <div class="d-flex align-items-center gap-4">
                <!-- Tanggal -->
                <div class="text-center px-3">
                    <div class="fw-bold fs-4 mb-0 text-primary">
                        {{ \Carbon\Carbon::parse($itemIGD->waktu_asesmen)->format('d') }}
                    </div>
                    <div class="text-muted" style="font-size: 0.85rem;">
                        {{ \Carbon\Carbon::parse($itemIGD->waktu_asesmen)->format('M-y') }}
                    </div>
                    <div class="text-muted" style="font-size: 0.85rem;">
                        {{ \Carbon\Carbon::parse($itemIGD->waktu_asesmen)->format('H:i') }}
                    </div>
                </div>

                <!-- Avatar dan Info -->
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset('assets/images/avatar1.png') }}" class="rounded-circle border border-2"
                        alt="Foto Pasien" width="60" height="60">
                    <div>
                        <div class="text-primary fw-bold mb-1">
                            Asesmen {{ getKategoriAsesmen($itemIGD->kategori, $itemIGD->sub_kategori, 3) }}
                        </div>
                        <div class="text-muted">
                            By: <span class="fw-semibold">{{ $itemIGD->user->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2">
                @if ($itemIGD->kategori == 1)
                    <button type="button" onclick="showAsesmen('{{ $itemIGD->id }}')" {{--
                        data-url="{{ url('unit-pelayanan/gawat-darurat/pelayanan/' . $transaksiIGD->kd_pasien . '/' . \Carbon\Carbon::parse($transaksiIGD->tgl_transaksi)->format('Y-m-d') . '/' . $transaksiIGD->urut_masuk . '/asesmen/' . $itemIGD->id) }}"
                        --}}
                        data-url="{{ route('rawat-inap.asesmen.medis.umum.medis-igd', [$dataMedis->kd_unit, $transaksiIGD->kd_pasien, date('Y-m-d', strtotime($transaksiIGD->tgl_transaksi)), $transaksiIGD->urut_masuk, $itemIGD->id]) }}"
                        class="btn btn-info btn-sm px-3">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </button>
                @elseif($itemIGD->kategori == 2)
                    <a href="{{ route('rawat-inap.asesmen.keperawatan.umum.keperawatan-igd', [$dataMedis->kd_unit, $transaksiIGD->kd_pasien, date('Y-m-d', strtotime($transaksiIGD->tgl_transaksi)), $transaksiIGD->urut_masuk, $itemIGD->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>
                @endif
            </div>
        </li>
    @endforeach
</ul>

@if (count($asesmenIGD) > 0)
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.show')
@endif
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen.create-asesmen')

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

                    const dateMatch = (!startDate || itemDate >= startDate) && (!endDate || itemDate <=
                        endDate);
                    const searchMatch = itemName.includes(search);

                    if (dateMatch && searchMatch) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        });

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

@push('css')
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
@endpush
