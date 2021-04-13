@php
use Illuminate\Support\Facades\Session;
$fitur_program = $fitur_program ?? array();
$menu_active = function($route) {
    $menu_active = Session::get('menu_active') ?? '';
    return $menu_active == $route ? ' active show ' : '';
};
$sub_menu_active = function($route) {
    $sub_menu_active = Session::get('sub_menu_active') ?? '';
    return $sub_menu_active == $route ? ' active ' : '';
};
@endphp
<nav class="bottom-navbar">
    <div class="container">
        <ul class="nav page-navigation">
            @foreach($fitur_program as $fitur)
                @if($fitur->url != '#')
                    <li class="nav-item {{ $menu_active($fitur->url) }}">
                        <a href="{{ has_route($fitur->url) }}" class="nav-link">
                            <span class="link-title">{{ $fitur->name }}</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item {{ ($parent_active ?? '') == $fitur->name ? 'active' : '' }}">
                        <a href="#" class="nav-link">
                            <span class="menu-title">{{ $fitur->name }}</span>
                            <i class="link-arrow"></i>
                        </a>
                        <div class="submenu">
                            <ul class="submenu-item">
                                @foreach($fitur->children as $sub)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ has_route($sub->url) }}">{{ $sub->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</nav>
