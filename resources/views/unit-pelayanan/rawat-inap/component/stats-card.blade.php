<div class="col-12 col-md-6">
    <div class="row g-2">
        {{-- Aktif (Primary) --}}
        <a href="{{ route('rawat-inap.unit.aktif', $unit->kd_unit) }}" class="text-decoration-none col-12 col-md-4">
            <div class="rounded bg-primary text-white">
                <div class="card-body d-flex align-items-center gap-3 px-3">
                    <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36" height="36">
                    <div class="text-start">
                        <div class="small mb-1">Aktif</div>
                        <div class="fs-4 fw-bold">{{ countAktivePatientRanap($unit->kd_unit) }}</div>
                    </div>
                </div>
            </div>
        </a>

        {{-- Pending Order Masuk (Warning) --}}
        <a href="{{ route('rawat-inap.unit.pending', $unit->kd_unit) }}" class="text-decoration-none col-12 col-md-4">
            <div class="rounded bg-warning text-white">
                <div class="card-body d-flex align-items-center gap-3 px-3">
                    <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36" height="36">
                    <div class="text-start">
                        <div class="small mb-1">Pending Masuk</div>
                        <div class="fs-4 fw-bold">{{ countPendingPatientRanap($unit->kd_unit) }}</div>
                    </div>
                </div>
            </div>
        </a>

        {{-- Selesai --}}
        <a href="{{ route('rawat-inap.unit.selesai', $unit->kd_unit) }}" class="text-decoration-none col-12 col-md-4">
            <div class="rounded bg-success text-white">
                <div class="card-body d-flex align-items-center gap-3 px-3">
                    <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36" height="36">
                    <div class="text-start">
                        <div class="small mb-1">Selesai</div>
                        <div class="fs-4 fw-bold">-</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
