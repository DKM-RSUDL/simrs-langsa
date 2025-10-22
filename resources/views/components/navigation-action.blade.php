@props([
    'navItems' => [],
    'currentUrl' => null,
    'dataMedis' => null,
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
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Route;

    $current = $currentUrl ?? url()->current();
    $currentRouteName = Route::currentRouteName();
@endphp

<div class="card" style="height: auto;">
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
            @foreach ($navItems as $item)
                @php
                    // Determine active state:
                    // 1. If item provides 'active' (route name pattern), match against current route name using Str::is
                    // 2. Otherwise, check exact URL match or whether current URL starts with the item's link
$isActive = false;

if (!empty($item['active'])) {
    $isActive = Str::is($item['active'], $currentRouteName);
} else {
    // If link contains a wildcard pattern, use Str::is, else check exact match or prefix
    if (Str::contains($item['link'], '*')) {
        $isActive = Str::is($item['link'], $current);
    } else {
        $isActive = $current === $item['link'] || Str::startsWith($current, $item['link']);
                        }
                    }
                @endphp
                @if (
                    ($item['validate'] ?? false) === false ||
                        (($item['validate'] ?? false) === true && ($dataMedis->triase_proses ?? null) == 0))
                    <a href="{{ $item['link'] }}"
                        class="btn {{ $isActive ? 'btn-primary' : 'btn-light' }} d-flex align-items-center"
                        style="font-size: 14px;">
                        <img src="{{ asset('assets/img/icons/' . $item['icon']) }}" alt="{{ $item['label'] }}"
                            width="18" height="18" class="me-1">
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>
