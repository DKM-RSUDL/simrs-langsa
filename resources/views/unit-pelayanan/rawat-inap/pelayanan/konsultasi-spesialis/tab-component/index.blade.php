<ul class= "nav d-flex"id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ $active == 1 ? 'active' : '' }} fw-bold" id="resep-tab" data-bs-toggle="tab" data-bs-target="#resep"
            type="button" role="tab" aria-controls="resep" aria-selected="true">
            Konsultasi Minta
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ $active == 2 ? 'active' : '' }} fw-bold" id="resep-tab" data-bs-toggle="tab" data-bs-target="#resep"
            type="button" role="tab" aria-controls="resep" aria-selected="true">
            Konsultasi Terima
        </button>
    </li>
</ul>
