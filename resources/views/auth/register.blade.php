<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'API SaaS') }} - Sign Up</title>
    <meta name="description" content="Create your account">
    <meta name="viewport" content="width=device-width, maximum-scale=5, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

    <!-- up to 10% speed up for external res -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com/">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com/">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <!-- preloading icon font is helping to speed up a little bit -->
    <link rel="preload" href="{{ asset('smarty/fonts/flaticon/Flaticon.woff2') }}" as="font" type="font/woff2" crossorigin>

    <link rel="stylesheet" href="{{ asset('smarty/css/core.min.css') }}">
    <link rel="stylesheet" href="{{ asset('smarty/css/vendor_bundle.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('smarty/images/logo/icon_512x512.png') }}">
</head>
<body>
    <div id="wrapper">
        <!-- light logo -->
        <a aria-label="go back" href="{{ route('home') }}" class="position-absolute top-0 start-0 my-2 mx-4 z-index-3 h--70 d-inline-flex align-items-center">
            <span class="text-white fs-4 fw-bold">{{ config('app.name', 'API SaaS') }}</span>
        </a>

        <div class="d-lg-flex text-white min-vh-100" style="background: linear-gradient(180deg,#42404e 0,#1b1e29);">
            <div class="col-12 col-lg-5 d-lg-flex">
                <div class="w-100 align-self-center">
                    <div class="py-7 px-5">
                        <h1 class="d-inline-block text-align-end text-center-md text-center-xs display-4 w-100 max-w-600">
                            Join
                            <span class="display-3 d-block fw-medium">
                                {{ config('app.name', 'API SaaS') }}
                            </span>
                        </h1>
                        <p class="lead text-center-md text-center-xs opacity-75">
                            Start building amazing applications with our powerful API services
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7 d-lg-flex">
                <div class="w-100 align-self-center text-center-md text-center-xs p-2">
                    <!-- Register Form -->
                    <form novalidate action="{{ route('register') }}" method="POST" class="bs-validate p-5 py-6 rounded d-inline-block bg-white text-dark w-100 max-w-600">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <div class="form-floating mb-3">
                            <input required 
                                   placeholder="Full Name" 
                                   id="name" 
                                   name="name" 
                                   type="text" 
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   autofocus>
                            <label for="name">Full Name</label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input required 
                                   placeholder="Email" 
                                   id="email" 
                                   name="email" 
                                   type="email" 
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}">
                            <label for="email">Email</label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input required 
                                   placeholder="Password" 
                                   id="password" 
                                   name="password" 
                                   type="password" 
                                   class="form-control @error('password') is-invalid @enderror">
                            <label for="password">Password</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input required 
                                   placeholder="Confirm Password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   type="password" 
                                   class="form-control">
                            <label for="password_confirmation">Confirm Password</label>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6 mt-4">
                                <button type="submit" class="btn btn-primary w-100 transition-hover-top">
                                    Create Account
                                </button>
                            </div>

                            <div class="col-12 col-md-6 mt-4 text-align-end text-center-xs">
                                <a href="{{ route('login') }}" class="btn px-0 link-normal">
                                    Already have an account?
                                </a>
                            </div>
                        </div>

                        <div class="text-center my-4">
                            <div class="divider">
                                <span class="divider-content">OR</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('auth.google') }}" class="btn btn-outline-primary w-100 transition-hover-top">
                                    <svg class="me-2" width="18" height="18" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                    </svg>
                                    Sign up with Google
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Cookie Alert -->
                    <div class="alert bg-white text-dark p-3 my-2 border-0 rounded d-inline-block w-100 max-w-600">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ config('app.name') }} uses cookies for best experience! <a href="#" class="link-muted">Learn more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('smarty/js/core.min.js') }}"></script>
</body>
</html>