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

<div class="d-flex justify-content-start align-items-center m-3">
    <div class="row g-3 w-100">

        <!-- Button "Tambah" di sebelah kanan -->
        <div class="col-md-2 text-end ms-auto">
            @if (empty($laporan))
                <a href="{{ route('operasi.pelayanan.laporan-operasi.create', [$dataMedis->kd_pasien,date('Y-m-d', strtotime($dataMedis->tgl_masuk)),$dataMedis->urut_masuk]) }}"
                class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah
                </a>
            @endif
        </div>
    </div>
</div>

@if(!empty($laporan))
    <ul class="list-group" id="laporan-oprasi-list">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                <!-- Tanggal -->
                <div class="text-center px-3">
                    <div class="fw-bold fs-4 mb-0 text-primary">
                        {{ date('d', strtotime($laporan->created_at)) }}
                    </div>
                    <div class="text-muted" style="font-size: 0.85rem;">
                        {{ date('M-y', strtotime($laporan->created_at)) }}
                    </div>
                    <div class="text-muted" style="font-size: 0.85rem;">
                        {{ date('H:i', strtotime($laporan->created_at)) }}
                    </div>
                </div>

                <!-- Avatar dan Info -->
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset('assets/images/avatar1.png') }}" class="rounded-circle border border-2"
                        alt="Foto Pasien" width="60" height="60">
                    <div>
                        <div class="text-primary fw-bold mb-1">
                            Laporan Operasi
                        </div>
                        <div class="text-muted">
                            By: {{ $laporan->userCreate->karyawan->gelar_depan . ' ' . str()->title($laporan->userCreate->karyawan->nama) . ' ' . $laporan->userCreate->karyawan->gelar_belakang }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2">
                <a href="{{ route('operasi.pelayanan.laporan-operasi.show', [$dataMedis->kd_pasien,date('Y-m-d', strtotime($dataMedis->tgl_masuk)),$dataMedis->urut_masuk]) }}" class="btn btn-info btn-sm px-3">
                    <i class="fas fa-eye me-1"></i>
                    Lihat
                </a>

                <a href="{{ route('operasi.pelayanan.laporan-operasi.edit', [$dataMedis->kd_pasien,date('Y-m-d', strtotime($dataMedis->tgl_masuk)),$dataMedis->urut_masuk]) }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
            </div>
        </li>
    </ul>
@endif