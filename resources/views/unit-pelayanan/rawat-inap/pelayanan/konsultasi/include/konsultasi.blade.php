<div class="d-flex flex-column gap-2">
    <div class="row">
        <div class="col-md-10 d-flex flex-md-row flex-wrap flex-md-nowrap gap-2">
            <!-- Select Option -->
            <div>
                <select class="form-select" id="SelectOptionPAA" aria-label="Pilih...">
                    <option value="semua" selected>-- PPA --</option>
                    <option value="optionPPA1">Semua PPA</option>
                    <option value="optionPPA2">Dokter Spesialis</option>
                    <option value="optionPPA3">Dokter Umum</option>
                    <option value="optionPPA4">Perawat/Bidan</option>
                    <option value="optionPPA5">Nutrisionis</option>
                    <option value="optionPPA6">Apoteker</option>
                    <option value="optionPPA7">Fisioterapis</option>
                </select>
            </div>

            <div>
                <select class="form-select" id="SelectOption" aria-label="Pilih...">
                    <option value="semua" selected>-- Episode --</option>
                    <option value="option1">Episode Sekarang</option>
                    <option value="option2">1 Bulan</option>
                    <option value="option3">3 Bulan</option>
                    <option value="option4">6 Bulan</option>
                    <option value="option5">9 Bulan</option>
                </select>
            </div>

            <!-- Start Date -->
            <div>
                <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Dari Tanggal">
            </div>

            <!-- End Date -->
            <div>
                <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
            </div>

            <!-- Button Filter -->
            <div>
                <button id="filterButton" class="btn btn-secondary rounded-3"><i class="bi bi-funnel-fill"></i></button>
            </div>

            <!-- Search Bar -->
            <div>
                <form method="GET"
                    action="{{ route('rawat-inap.konsultasi.index', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="dokter & Konsulen"
                            aria-label="Cari" value="{{ request('search') }}" aria-describedby="basic-addon1">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Button -->
        <div class="col-md-2 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKonsulModal">
                <i class="bi bi-plus"></i>Tambah
            </button>
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
                        <td>{{ $konsul->dokter_asal->nama_lengkap }}</td>
                        <td>{{ $konsul->unit_tujuan->nama_unit }}</td>
                        <td>
                            <p class="text-primary fw-bold m-0 p-0" id="konsulenHarapLabel">{{ $konsulenHarapLabel }}
                            </p>
                            <p class="m-0 p-0" id="konsulDimintaLabel">{{ $konsul->konsul }}</p>
                        </td>
                        <td>
                            <p class="text-primary fw-bold m-0 p-0" id="konsulenStatusLabel">
                                {{ $konsul->status == 1 ? 'Diterima' : 'Dikirim' }}</p>
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('rawat-inap.konsultasi.rincian.show', [
                                $dataMedis->kd_unit,
                                $dataMedis->kd_pasien,
                                $dataMedis->tgl_masuk,
                                $dataMedis->urut_masuk,
                                $konsul->urut_konsul,
                            ]) }}"
                                class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button class="btn btn-sm btn-warning btn-edit-konsultasi" data-bs-target="#editKonsulModal"
                                data-unittujuan="{{ $konsul->kd_unit_tujuan }}"
                                data-tglkonsul="{{ $konsul->tgl_masuk_tujuan }}"
                                data-jamkonsul="{{ $konsul->jam_masuk_tujuan }}"
                                data-urutkonsul="{{ $konsul->urut_konsul }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" data-unittujuan="{{ $konsul->kd_unit_tujuan }}"
                                data-tglkonsul="{{ $konsul->tgl_masuk_tujuan }}"
                                data-jamkonsul="{{ $konsul->jam_masuk_tujuan }}"
                                data-urutkonsul="{{ $konsul->urut_konsul }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('unit-pelayanan.rawat-jalan.pelayanan.konsultasi.include.modal')
