<div class="d-flex justify-content-between align-items-center m-3">

    <div class="row">
        <!-- Select Option -->
        <div class="col-md-2">
            <select class="form-select" id="SelectOption" aria-label="Pilih...">
                <option value="semua" selected>Semua PPA</option>
                <option value="option1">Semua PPA</option>
                <option value="option2">Dokter Spesialis</option>
                <option value="option3">Dokter Umum</option>
                <option value="option4">Perawat/Bidan</option>
                <option value="option5">Nutrisionis</option>
                <option value="option6">Apoteker</option>
                <option value="option7">Fisioterapis</option>
            </select>
        </div>

        <div class="col-md-2">
            <select class="form-select" id="SelectOption" aria-label="Pilih...">
                <option value="semua" selected>Semua Episode</option>
                <option value="option1">Episode Sekarang</option>
                <option value="option2">1 Bulan</option>
                <option value="option3">3 Bulan</option>
                <option value="option4">6 Bulan</option>
                <option value="option5">9 Bulan</option>
            </select>
        </div>

        <!-- Start Date -->
        <div class="col-md-1">
            <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Dari Tanggal">
        </div>

        <!-- End Date -->
        <div class="col-md-1">
            <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
        </div>

        <!-- Button Filter -->
        <div class="col-md-1">
            <button id="filterButton" class="btn btn-secondary rounded-3"><i class="bi bi-funnel-fill"></i></button>
        </div>

        <!-- Search Bar -->
        <div class="col-md-3">
            <form method="GET" action="#">

                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control" placeholder="Cari" aria-label="Cari"
                        value="" aria-describedby="basic-addon1">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>

        <!-- Add Button -->
        <div class="col-md-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKonsulModal"><i
                    class="bi bi-plus"></i>Tambah</button>
        </div>

    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-sm table-hover" id="rawatDaruratKonsultasiTable">
        <thead class="table-primary">
            <tr>
                <th>Tanggal</th>
                <th>Dari PPA</th>
                <th>Konsulen</th>
                <th>Konsul yang diminta</th>
                <th>Status Konsul</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($konsultasi as $konsul)
                @php
                    $konsulenHarap = $konsul->kd_konsulen_diharapkan;
                    $konsulenHarapLabel = '';

                    switch ($konsulenHarap) {
                        case 1:
                            $konsulenHarapLabel = 'Konsul Sewaktu';
                            break;
                        case 2:
                            $konsulenHarapLabel = 'Rawat Bersama';
                            break;
                        case 3:
                            $konsulenHarapLabel = 'Alih Rawat';
                            break;
                        case 4:
                            $konsulenHarapLabel =
                                'Kembali ke unit yang meminta untuk persetujuan tindakan & pengobatan';
                            break;
                    }
                @endphp

                <tr>
                    <td>{{ date('d M Y', strtotime($konsul->tgl_masuk_tujuan)) }}
                        {{ date('H:i', strtotime($konsul->jam_masuk_tujuan)) }}</td>
                    <td>{{ $konsul->dokter_asal->nama_lengkap }} ({{ $konsul->unit_asal->nama_unit ?? '-' }})</td>
                    <td>{{ $konsul->unit_tujuan->nama_unit }}</td>
                    <td>
                        <p class="text-primary fw-bold m-0 p-0" id="konsulenHarapLabel">{{ $konsulenHarapLabel }}</p>
                        <p class="m-0 p-0" id="konsulDimintaLabel">{{ $konsul->konsul }}</p>
                    </td>
                    <td>
                        <p class="text-primary fw-bold m-0 p-0" id="konsulenStatusLabel">Dikirim</p>
                        {{-- <p class="m-0 p-0" id="konsulenKetLabel">Saran untuk dilakukan pemeriksaan</p> --}}
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-edit-konsultasi" data-bs-target="#editKonsulModal"
                            data-unittujuan="{{ $konsul->kd_unit_tujuan }}"
                            data-tglkonsul="{{ $konsul->tgl_masuk_tujuan }}"
                            data-jamkonsul="{{ $konsul->jam_masuk_tujuan }}"
                            data-urutkonsul="{{ $konsul->urut_konsul }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-delete-konsultasi"
                            data-unittujuan="{{ $konsul->kd_unit_tujuan }}"
                            data-tglkonsul="{{ $konsul->tgl_masuk_tujuan }}"
                            data-jamkonsul="{{ $konsul->jam_masuk_tujuan }}"
                            data-urutkonsul="{{ $konsul->urut_konsul }}">
                            <i class="bi bi-x-circle-fill text-danger"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.konsultasi.include.modal')
