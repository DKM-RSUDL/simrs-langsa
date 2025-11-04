<nav class="main-sidebar ps-menu">
    <div class="sidebar-header d-flex align-items-start justify-content-between">
        <div class="d-flex gap-3 align-items-center justify-content-between" style="margin-left: -2px">
            <img src="/assets/img/emris.png" width="50" height="50" alt=""
                style="object-fit: cover; aspect-ratio: 1:1;" />
            <div class="text">EMRIS
            </div>
        </div>
        {{-- <div class="text">Administrator</div> --}}
        <div class="close-sidebar action-toggle">
            <i class="ti-close"></i>
        </div>
    </div>
    <div class="sidebar-content">
        <ul>
            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="link">
                    <i class="fa-solid fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-category">
                <span class="text-uppercase">Data Master</span>
            </li>

            @php
                $pelayananMenus = getMenus()->filter(function ($menu) {
                    return in_array($menu->name, ['Unit Pelayanan', 'unit pelayanan']);
                });
                $lainLainMenus = getMenus()->filter(function ($menu) {
                    return in_array($menu->name, ['Transfusi Darah', 'transfusi darah']);
                });
                $otherMenus = getMenus()->filter(function ($menu) {
                    return !in_array($menu->name, [
                        'Unit Pelayanan',
                        'unit pelayanan',
                        'Transfusi Darah',
                        'transfusi darah',
                    ]);
                });
            @endphp

            @foreach ($otherMenus as $menu)
                @can('read ' . $menu->url)
                    @if ($menu->type_menu == 'parent')
                        @php
                            $isActiveParent = false;
                            if ($menu->url && request()->is($menu->url . '*')) {
                                $isActiveParent = true;
                            }
                            foreach ($menu->subMenus as $submenu) {
                                if (request()->is($submenu->url . '*')) {
                                    $isActiveParent = true;
                                    break;
                                }
                            }
                        @endphp
                        <li class="{{ $isActiveParent ? 'active open' : '' }}">
                            <a href="#" class="main-menu has-dropdown">
                                <i class="{{ $menu->icon }}"></i>
                                <span class="text-capitalize">{{ $menu->name }}</span>
                            </a>
                            <ul class="sub-menu {{ $isActiveParent ? 'expand' : '' }}">
                                @foreach ($menu->subMenus as $submenu)
                                    @can('read ' . $submenu->url)
                                        <li class="{{ request()->is($submenu->url . '*') ? 'active' : '' }}">
                                            <a href="{{ url($submenu->url) }}" class="link">
                                                <span class="text-capitalize">{{ $submenu->name }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                @endforeach
                            </ul>
                        </li>
                    @elseif ($menu->type_menu == 'single')
                        <li class="{{ request()->is($menu->url . '*') ? 'active' : '' }}">
                            <a href="{{ url($menu->url) }}" class="link">
                                <i class="{{ $menu->icon }}"></i>
                                <span class="text-capitalize">{{ $menu->name }}</span>
                            </a>
                        </li>
                    @endif
                @endcan
            @endforeach

            @if ($pelayananMenus->count() > 0)
                <li class="menu-category">
                    <span class="text-uppercase">Pelayanan</span>
                </li>

                @foreach ($pelayananMenus as $menu)
                    @can('read ' . $menu->url)
                        @if ($menu->type_menu == 'parent')
                            @php
                                $isActiveParent = false;
                                if ($menu->url && request()->is($menu->url . '*')) {
                                    $isActiveParent = true;
                                }
                                foreach ($menu->subMenus as $submenu) {
                                    if (request()->is($submenu->url . '*')) {
                                        $isActiveParent = true;
                                        break;
                                    }
                                }
                            @endphp
                            <li class="{{ $isActiveParent ? 'active open' : '' }}">
                                <a href="#" class="main-menu has-dropdown">
                                    <i class="{{ $menu->icon }}"></i>
                                    <span class="text-capitalize">{{ $menu->name }}</span>
                                </a>
                                <ul class="sub-menu {{ $isActiveParent ? 'expand' : '' }}">
                                    @foreach ($menu->subMenus as $submenu)
                                        @can('read ' . $submenu->url)
                                            <li class="{{ request()->is($submenu->url . '*') ? 'active' : '' }}">
                                                <a href="{{ url($submenu->url) }}" class="link">
                                                    <span class="text-capitalize">{{ $submenu->name }}</span>
                                                </a>
                                            </li>
                                        @endcan
                                    @endforeach
                                </ul>
                            </li>
                        @elseif ($menu->type_menu == 'single')
                            <li class="{{ request()->is($menu->url . '*') ? 'active' : '' }}">
                                <a href="{{ url($menu->url) }}" class="link">
                                    <i class="{{ $menu->icon }}"></i>
                                    <span class="text-capitalize">{{ $menu->name }}</span>
                                </a>
                            </li>
                        @endif
                    @endcan
                @endforeach
            @endif

            @if ($lainLainMenus->count() > 0)
                <li class="menu-category">
                    <span class="text-uppercase">Lain-lain</span>
                </li>

                @foreach ($lainLainMenus as $menu)
                    @can('read ' . $menu->url)
                        @if ($menu->type_menu == 'parent')
                            @php
                                $isActiveParent = false;
                                if ($menu->url && request()->is($menu->url . '*')) {
                                    $isActiveParent = true;
                                }
                                foreach ($menu->subMenus as $submenu) {
                                    if (request()->is($submenu->url . '*')) {
                                        $isActiveParent = true;
                                        break;
                                    }
                                }
                            @endphp
                            <li class="{{ $isActiveParent ? 'active open' : '' }}">
                                <a href="#" class="main-menu has-dropdown">
                                    <i class="{{ $menu->icon }}"></i>
                                    <span class="text-capitalize">{{ $menu->name }}</span>
                                </a>
                                <ul class="sub-menu {{ $isActiveParent ? 'expand' : '' }}">
                                    @foreach ($menu->subMenus as $submenu)
                                        @can('read ' . $submenu->url)
                                            <li class="{{ request()->is($submenu->url . '*') ? 'active' : '' }}">
                                                <a href="{{ url($submenu->url) }}" class="link">
                                                    <span class="text-capitalize">{{ $submenu->name }}</span>
                                                </a>
                                            </li>
                                        @endcan
                                    @endforeach
                                </ul>
                            </li>
                        @elseif ($menu->type_menu == 'single')
                            <li class="{{ request()->is($menu->url . '*') ? 'active' : '' }}">
                                <a href="{{ url($menu->url) }}" class="link">
                                    <i class="{{ $menu->icon }}"></i>
                                    <span class="text-capitalize">{{ $menu->name }}</span>
                                </a>
                            </li>
                        @endif
                    @endcan
                @endforeach
            @endif
        </ul>
    </div>
</nav>
