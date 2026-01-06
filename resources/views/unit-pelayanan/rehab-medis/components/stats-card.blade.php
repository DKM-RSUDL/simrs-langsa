{{-- Aktif (Primary) --}}
<div class="col-md-6">
    <a href="{{ route('rehab-medis.index') }}" class="text-decoration-none col-6 ms-auto">
        <div class="rounded bg-primary text-white">
            <div class="card-body d-flex align-items-center gap-3 px-3">
                <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36" height="36">
                <div class="text-start">
                    <div class="small mb-1">Aktif</div>
                    <div class="fs-4 fw-bold">{{ countUnfinishedPatientWithTglKeluar(74) }}</div>
                </div>
            </div>
        </div>
    </a>
</div>

{{-- Pending (Warning) --}}
<div class="col-md-6">
    <a href="{{ route('rehab-medis.pending') }}" class="text-decoration-none col-6 ms-auto">
        <div class="rounded bg-warning text-white">
            <div class="card-body d-flex align-items-center gap-3 px-3">
                <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36" height="36">
                <div class="text-start">
                    <div class="small mb-1">Pending Order</div>
                    <div class="fs-4 fw-bold">{{ countPendingOrderRehabMedik() }}</div>
                </div>
            </div>
        </div>
    </a>
</div>
