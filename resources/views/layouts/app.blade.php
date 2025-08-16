<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'API SaaS') }}</title>
    <meta name="description" content="Powerful API services for your applications">
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

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('smarty/images/logo/icon_512x512.png') }}">

    <style>
        /* Header scroll improvements */
        .header-sticky {
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        
        .header-sticky.scrolled {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
        }
        
        .header-sticky.scrolled .navbar-brand,
        .header-sticky.scrolled .nav-link {
            color: #333 !important;
        }
        
        .header-sticky.scrolled .navbar-toggler svg path {
            fill: #333 !important;
        }
        
        /* Divider styles for auth forms */
        .divider {
            position: relative;
            text-align: center;
            margin: 1rem 0;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #dee2e6;
        }
        
        .divider-content {
            background: white;
            padding: 0 1rem;
            color: #6c757d;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="header-sticky">
    <div id="wrapper">
        <!-- Header -->
        <header id="header" class="shadow-xs">
            <!-- Navbar -->
            <div class="container position-relative">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <!-- mobile menu button : show -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                        <svg width="25" viewBox="0 0 20 20">
                            <path d="M 19.9876 1.998 L -0.0108 1.998 L -0.0108 -0.0019 L 19.9876 -0.0019 L 19.9876 1.998 Z"></path>
                            <path d="M 19.9876 7.9979 L -0.0108 7.9979 L -0.0108 5.9979 L 19.9876 5.9979 L 19.9876 7.9979 Z"></path>
                            <path d="M 19.9876 13.9977 L -0.0108 13.9977 L -0.0108 11.9978 L 19.9876 11.9978 L 19.9876 13.9977 Z"></path>
                            <path d="M 19.9876 19.9976 L -0.0108 19.9976 L -0.0108 17.9976 L 19.9876 17.9976 L 19.9876 19.9976 Z"></path>
                        </svg>
                    </button>

                    <!-- navbar : brand (logo) -->
                    <a class="navbar-brand" href="{{ route('home') }}">
                        {{ config('app.name', 'API SaaS') }}
                    </a>

                    <!-- Menu -->
                    <div class="collapse navbar-collapse navbar-animate-fadein" id="navbarMainNav">
                        <!-- navbar : mobile menu -->
                        <div class="navbar-xs d-none">
                            <!-- mobile menu button : close -->
                            <button class="navbar-toggler pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                                <svg width="20" viewBox="0 0 20 20">
                                    <path d="M 20.7895 0.977 L 19.3752 -0.4364 L 10.081 8.8522 L 0.7869 -0.4364 L -0.6274 0.977 L 8.6668 10.2656 L -0.6274 19.5542 L 0.7869 20.9676 L 10.081 11.679 L 19.3752 20.9676 L 20.7895 19.5542 L 11.4953 10.2656 L 20.7895 0.977 Z"></path>
                                </svg>
                            </button>

                            <!-- Mobile Menu Logo -->
                            <a class="navbar-brand" href="{{ route('home') }}">
                                {{ config('app.name', 'API SaaS') }}
                            </a>
                        </div>

                        <!-- navbar : navigation -->
                        <ul class="navbar-nav">
                            <!-- home -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>

                            <!-- pricing -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}#pricing">Pricing</a>
                            </li>

                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                            @endauth

                            <!-- contact -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                            </li>
                        </ul>
                        <!-- /navbar : navigation -->

                        <!-- OPTIONS (moved inside navbar-collapse for mobile) -->
                        <ul class="list-inline list-unstyled mb-0 d-flex align-items-center ms-auto">
                        @auth
                            <li class="list-inline-item mx-1 dropdown">
                                <a href="#" aria-label="Account Options" id="dropdownAccountOptions" class="btn btn-sm btn-primary" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                    <span class="group-icon float-start">
                                        <i class="fi fi-user-male"></i>
                                        <i class="fi fi-close"></i>
                                    </span>
                                    <span>{{ Auth::user()->name }}</span>
                                </a>

                                <div aria-labelledby="dropdownAccountOptions" class="list-unstyled dropdown-menu dropdown-menu-clean dropdown-click-ignore end-0 py-2 rounded-xl" style="min-width:215px;">
                                    <div class="dropdown-header px-4 mb-1 text-wrap fw-medium">{{ Auth::user()->name }}</div>
                                    <div class="dropdown-divider mb-3"></div>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <svg class="text-gray-600 float-start" width="18px" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8 3.293l6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"></path>
                                            <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"></path>
                                        </svg>
                                        <span>Dashboard</span>
                                    </a>
                                    <div class="dropdown-divider mt-3"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item mt-1 border-0 bg-transparent text-start w-100">
                                            <i class="fi fi-power float-start"></i>
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @else
                            <li class="list-inline-item mx-1">
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Login</a>
                            </li>
                            <li class="list-inline-item mx-1">
                                <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Sign Up</a>
                            </li>
                        @endauth
                        </ul>
                        <!-- /OPTIONS -->
                    </div>
                    </div>
                </nav>
            </div>
        </header>

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="section text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold">{{ config('app.name', 'API SaaS') }}</h5>
                    <p class="opacity-75">Powerful API services for your applications. Scale your business with our reliable infrastructure.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="mb-3">
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle me-2">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle me-2">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                    <p class="opacity-75 mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'API SaaS') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('smarty/js/core.min.js') }}"></script>
    <script src="{{ asset('smarty/js/vendor_bundle.min.js') }}"></script>
    
    <script>
        // Header scroll behavior
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>