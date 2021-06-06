@php
    $features = $features ?? array();
@endphp
<nav class="bottom-navbar">
    <div class="container">
        <ul class="nav page-navigation">
            @foreach($features as $feature)
                @if($feature->url != '#')
                    <li class="nav-item">
                        <a href="{{ has_route($feature->url) }}" class="nav-link">
                            <span class="link-title">{{ $feature->name }}</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="menu-title">{{ $feature->name }}</span>
                            <i class="link-arrow"></i>
                        </a>
                        <div class="submenu">
                            <ul class="submenu-item">
                                @foreach($feature->children as $sub)
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
