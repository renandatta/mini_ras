@extends('layouts.index')

@section('body')
    <div class="main-wrapper">
        <div class="horizontal-menu">
            <nav class="navbar top-navbar">
                <div class="container">
{{--                    <div class="navbar-content">--}}
{{--                        <a href="#" class="navbar-brand">--}}
{{--                            <img src="{{ asset('images/logo.png') }}" alt="" class="img-fluid" style="height:40px;">--}}
{{--                        </a>--}}
{{--                        <ul class="navbar-nav">--}}
{{--                            <li class="nav-item dropdown nav-apps">--}}
{{--                                <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                    <i data-feather="grid"></i>--}}
{{--                                </a>--}}
{{--                                <div class="dropdown-menu" aria-labelledby="appsDropdown">--}}
{{--                                    <div class="dropdown-body my-2">--}}
{{--                                        <div class="row d-flex align-items-center apps mx-auto justify-content-center">--}}
{{--                                            @php($list_modul = $list_modul ?? [])--}}
{{--                                            @foreach($list_modul as $modul)--}}
{{--                                                <div class="col-md-4 text-center">--}}
{{--                                                    <a href="{{ has_route($modul->url) }}">--}}
{{--                                                        <img src="{{ asset("icons/$modul->icon") }}" height="30" alt="">--}}
{{--                                                        <p>{{ $modul->nama }}</p>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item dropdown nav-profile">--}}
{{--                                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown">--}}
{{--                                    <img src="{{ asset('images/user.png') }}" alt="profile">--}}
{{--                                </a>--}}
{{--                                <div class="dropdown-menu" aria-labelledby="profileDropdown">--}}
{{--                                    @php($user = \Illuminate\Support\Facades\Auth::user() ?? [])--}}
{{--                                    <div class="dropdown-header d-flex flex-column align-items-center">--}}
{{--                                        <div class="info text-center">--}}
{{--                                            <p class="name font-weight-bold mb-0">{{ $user->nama ?? 'Nama User' }}</p>--}}
{{--                                            <p class="email text-muted mb-3">{{ $user->user_level->nama ?? '' }}</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="dropdown-body">--}}
{{--                                        <ul class="profile-nav p-0 pt-3">--}}
{{--                                            <li class="nav-item">--}}
{{--                                                <a href="#" class="nav-link">--}}
{{--                                                    <i data-feather="edit"></i>--}}
{{--                                                    <span>Edit Profile</span>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                            <li class="nav-item">--}}
{{--                                                <a href="{{ has_route('logout') }}" class="nav-link">--}}
{{--                                                    <i data-feather="log-out"></i>--}}
{{--                                                    <span>Log Out</span>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">--}}
{{--                            <i data-feather="menu"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
                </div>
            </nav>
{{--            @include('layouts._navbar')--}}
        </div>
        <div class="page-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
            <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
                <p class="text-muted text-center text-md-left">
                    Copyright © {{ date('Y') }} <a href="https://renandatta.com" target="_blank">renandatta</a>. All rights reserved
                </p>
            </footer>
        </div>
    </div>
@endsection
