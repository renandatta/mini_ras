@extends('layouts.app')

@section('body')
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">

                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-8 col-xl-6 mx-auto">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-4 pr-md-0">
                                    <div class="auth-left-wrapper" style="background-image: url('{{ asset('images/img6.jpeg') }}')">
                                    </div>
                                </div>
                                <div class="col-md-8 pl-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <a href="#" class="noble-ui-logo d-block mb-2">12K<span>Putri</span></a>
                                        <h5 class="text-muted font-weight-normal mb-4">Create new account.</h5>
                                        @if ($errors->any())
                                            <x-alert type="error" display="true">
                                                <ul class="mb-0" style="margin-left: -20px">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </x-alert>
                                        @endif
                                        <form class="forms-sample" action="{{ route('register') }}" method="post">
                                            @csrf
                                            <x-form-group id="name" caption="Name">
                                                <x-input name="name" caption="Name" />
                                            </x-form-group>
                                            <x-form-group id="email" caption="Email">
                                                <x-input name="email" caption="Email" />
                                            </x-form-group>
                                            <x-form-group id="password" caption="Password">
                                                <x-input name="password" caption="Password" type="password" />
                                            </x-form-group>
                                            <div class="mt-3">
                                                <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">Register</button>
                                            </div>
                                            <a href="{{ route('login') }}" class="d-block mt-3 text-muted">Already have account? Sign In</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
