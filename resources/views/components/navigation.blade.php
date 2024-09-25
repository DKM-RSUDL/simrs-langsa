<div class="header-background">
    <div class="nav-icons shadow-lg">
        @foreach ($navItems as $item)
            <a href="{{ $item['link'] }}">
                <img src="{{ asset('assets/img/icons/' . $item['icon']) }}" alt="{{ $item['label'] }} Icon" width="25">
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>
