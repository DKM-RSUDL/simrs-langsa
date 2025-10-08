@props([
    'navItems' => [],
    'currentUrl' => null,
    'dataMedis' => null
])

@once
    @push('css')
        <style>
            .nav-icons {
                display: flex;
                gap: 5px;
                padding: 5px;
                background: white;
            }

            .nav-icons .nav-item {
                display: flex;
                align-items: center;
                gap: 5px;
                padding: 2px 2px;
                text-decoration: none;
                color: #ffffff;
                border-radius: 25px;
                transition: all 0.3s ease;
                border: 1px solid #cecece;
            }

            .nav-icons .nav-item:hover {
                background-color: #e9ecef;
            }

            .nav-icons .nav-item.active {
                background-color: #0d6efd;
            }

            .nav-icons .nav-item.active span {
                color: white;
            }

            .nav-icons .nav-item.active img {
                filter: none;
            }
        </style>
    @endpush
@endonce

@php
    $current = $currentUrl ?? url()->current();
@endphp

<div class="card" style="height: auto;">
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
            @foreach ($navItems as $item)
                @if (
                    ($item['validate'] ?? false) === false ||
                    (($item['validate'] ?? false) === true && ($dataMedis->triase_proses ?? null) == 0)
                )
                    <a href="{{ $item['link'] }}"
                        class="btn {{ $current === $item['link'] ? 'btn-primary' : 'btn-light' }} d-flex align-items-center"
                        style="font-size: 14px;">
                        <img src="{{ asset('assets/img/icons/' . $item['icon']) }}"
                            alt="{{ $item['label'] }}"
                            width="18"
                            height="18"
                            class="me-1">
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>
