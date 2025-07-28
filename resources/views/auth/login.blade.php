<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SeoDash Free Bootstrap Admin Template by Adminmart</title>
    <link rel="shortcut icon" type="image/png" href="images/logos/seodashlogo.png" />
    <link rel="stylesheet" href="{{asset('layout_assets/css/styles.min.css')}}" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{asset('layout_assets/images/logos/logo-light.svg')}}" alt="">
                                </a>
                                <p class="text-center">Your Social Campaigns</p>

                                <form method="POST" action="{{route('login')}}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Username</label>
                                        <input autofocus autocomplete="username" name="email" 
                                            class="form-control" >
                                    </div>
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input autocomplete="password" name="password" type="password" class="form-control"
                                            id="exampleInputPassword1">
                                    </div>
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" value=""
                                                id="flexCheckChecked" checked>
                                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                                Remeber this Device
                                            </label>
                                        </div>
                                        <a class="text-primary fw-bold" href="">Forgot Password ?</a>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">Sign In</button>

                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">New to SeoDash?</p>
                                        <a class="text-primary fw-bold ms-2"
                                            href="./authentication-register.html">Create an account</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('layout_assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('layout_assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>

{{--
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}