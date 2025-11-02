<div class="d-flex flex-column gap-2">
    <div class="d-flex align-items-center justify-content-between">
        @include('components.page-header', [
            'title' => 'Daftar Data Konsultasi/Rujukan',
            'description' => 'Berikut daftar data konsultasi/rujukan.',
        ])
    </div>
    <div class="row">
        <div class="col-md-10 d-flex flex-wrap flex-row flex-md-row gap-2 flex-md-nowrap">
            <!-- Select Option -->
            <div>
                <select class="form-select" id="SelectPPA" aria-label="Pilih...">
                    <option value="semua" selected>Semua PPA</option>
                    <option value="optionPPA1">Semua PPA</option>
                    <option value="optionPPA2">Dokter Spesialis</option>
                    <option value="optionPPA3">Dokter Umum</option>
                    <option value="optionPPA4">Perawat/Bidan</option>
                    <option value="optionPPA5">Nutrisionis</option>
                    <option value="optionPPA6">Apoteker</option>
                    <option value="optionPPA7">Fisioterapis</option>
                </select>
            </div>

            <!-- Select Option -->
            <div>
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
                    action="{{ route('konsultasi.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">

                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Dokter & Konsulen"
                            aria-label="Cari" value="{{ request('search') }}" aria-describedby="basic-addon1">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Button -->
        <div class="col-md-2 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKonsulModal"><i
                    class="bi bi-plus"></i>Tambah</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm table-hover" id="rawatDaruratKonsultasiTable">
            <thead class="table-primary">
                <tr>
                    <th>Tanggal</th>
                    <th>Dari</th>
                    <th>Konsulen</th>
                    {{-- <th>Konsul yang diminta</th> --}}
                    <th>Status Konsul</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($konsultasi as $konsul)
                    <tr>
                        <td>
                            {{ date('d M Y', strtotime($konsul->tgl_konsul)) }}
                            {{ date('H:i', strtotime($konsul->jam_konsul)) }}
                        </td>
                        <td>{{ $konsul->dokterAsal->nama_lengkap }}</td>
                        <td>{{ $konsul->dokterTujuan->nama_lengkap }}</td>
                        {{-- <td>
                        <p class="m-0 p-0" id="konsulDimintaLabel">{{ $konsul->konsultasi }}</p>
                    </td> --}}
                        <td>
                            @if (empty($konsul->instruksi))
                                <p class="text-warning fw-bold m-0 p-0" id="konsulenStatusLabel">Di kirim</p>
                            @else
                                <p class="text-success fw-bold m-0 p-0" id="konsulenStatusLabel">Di jawab</p>
                            @endif
                        </td>
                        <td>
                            <x-table-action>
                                <a href="{{ route('konsultasi.pdf', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, encrypt($konsul->id)]) }}"
                                    class="btn btn-sm btn-success btn-print-konsultasi" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                                <button class="btn btn-sm btn-warning btn-edit-konsultasi"
                                    data-bs-target="#editKonsulModal" data-konsul="{{ encrypt($konsul->id) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-delete-konsultasi btn-danger"
                                    data-konsul="{{ encrypt($konsul->id) }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </x-table-action>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.konsultasi.include.modal')
