<div class="row g-3 align-items-center">
    {{-- Kartu Aktif (Primary) --}}
    <a href="{{ route('gawat-darurat.index') }}" class="text-decoration-none col-6 ms-auto w-min">
        <div class="rounded bg-primary text-white">
            <div class="card-body d-flex align-items-center gap-3 px-3">
                <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36" height="36">
                <div class="text-start">
                    <div class="small mb-1">Aktif</div>
                    <div class="fs-4 fw-bold">{{ countActivePatientIGD() }}</div>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('gawat-darurat.selesai') }}" class="text-decoration-none col-6 ms-auto w-min">
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
