@php
    $tab = $_GET['ref'] ?? 'ri'
@endphp

<ul class="nav tab-minimal">
    <li class="nav-item py-2">
        <a href="?ref=ri" class="tab-link text-decoration-none {{ $tab == 'ri' ? 'active' : '' }}">Rawat Inap</a>
    </li>

    <li class="nav-item py-2">
        <a href="?ref=rj" class="tab-link text-decoration-none {{ $tab == 'rj' ? 'active' : '' }}">Rawat Jalan</a>
    </li>

</ul>
