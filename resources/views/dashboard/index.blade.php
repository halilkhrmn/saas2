@extends('layouts.app')

@section('content')
<div class="section">
    <div class="container">
        <div class="row">
            <!-- Account Sidebar -->
            <div class="col-12 col-lg-3">
                <nav class="scrollspy-nav sticky-top" style="top: 70px; z-index: 10;">
                    <div class="bg-white p-4 rounded shadow-primary-xs">
                        <ul class="nav flex-column">
                            <!-- Account name -->
                            <li>
                                <div class="d-flex align-items-center mb-2 pb-4 border-bottom">
                                    <div class="flex-none p-3 border rounded-circle">
                                        <svg class="text-gray-300" width="34px" height="34px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 460.8 460.8" fill="currentColor">
                                            <path d="M230.432,0c-65.829,0-119.641,53.812-119.641,119.641s53.812,119.641,119.641,119.641s119.641-53.812,119.641-119.641S296.261,0,230.432,0z"></path>
                                            <path d="M435.755,334.89c-3.135-7.837-7.314-15.151-12.016-21.943c-24.033-35.527-61.126-59.037-102.922-64.784c-5.224-0.522-10.971,0.522-15.151,3.657c-21.943,16.196-48.065,24.555-75.233,24.555s-53.29-8.359-75.233-24.555c-4.18-3.135-9.927-4.702-15.151-3.657c-41.796,5.747-79.412,29.257-102.922,64.784c-4.702,6.792-8.882,14.629-12.016,21.943c-1.567,3.135-1.045,6.792,0.522,9.927c4.18,7.314,9.404,14.629,14.106,20.898c7.314,9.927,15.151,18.808,24.033,27.167c7.314,7.314,15.673,14.106,24.033,20.898c41.273,30.825,90.906,47.02,142.106,47.02s100.833-16.196,142.106-47.02c8.359-6.269,16.718-13.584,24.033-20.898c8.359-8.359,16.718-17.241,24.033-27.167c5.224-6.792,9.927-13.584,14.106-20.898C436.8,341.682,437.322,338.024,435.755,334.89z"></path>
                                        </svg>
                                    </div>
                                    <div class="w-100 px-3">
                                        <span>Hello,</span>
                                        <span class="d-block fw-bold">
                                            {{ $user->name }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link px-0 d-flex align-items-center" href="{{ route('dashboard') }}">
                                    <svg class="text-gray-600 float-start" width="18px" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 3.293l6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"></path>
                                        <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"></path>
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-0 d-flex align-items-center" href="#">
                                    <svg class="text-gray-600 float-start" width="18px" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                                    </svg>
                                    <span>API Keys</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-0 d-flex align-items-center" href="{{ route('dashboard.invoices') }}">
                                    <svg class="text-gray-600 float-start" width="18px" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"></path>
                                        <path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3zm4.354 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"></path>
                                    </svg>
                                    <span>Invoices</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-0 d-flex align-items-center" href="#">
                                    <svg class="text-gray-600 float-start" width="18px" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                        <path fill-rule="evenodd" d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364L.102 2.223zm13.37 9.019L13 11l-.471.242-.529.026-.287.445-.445.287-.026.529L11 13l.242.471.026.529.445.287.287.445.529.026L13 15l.471-.242.529-.026.287-.445.445-.287.026-.529L15 13l-.242-.471-.026-.529-.445-.287-.287-.445-.529-.026z"></path>
                                    </svg>
                                    <span>Account settings</span>
                                </a>
                            </li>

                            <li class="nav-item border-top my-3"></li>

                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link px-0 btn btn-link text-start w-100 border-0 text-decoration-none d-flex align-items-center">
                                        <i class="fi fi-power float-start"></i>
                                        <span class="ms-2">Log Out</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-12 col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-2"></i>
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Welcome Header -->
                <div class="row mb-5">
                    <div class="col">
                        <div class="bg-gradient-primary rounded-4 p-5 text-white position-relative overflow-hidden">
                            <div class="position-absolute top-0 end-0 opacity-10">
                                <svg width="200" height="200" viewBox="0 0 200 200" fill="currentColor">
                                    <circle cx="100" cy="100" r="80"/>
                                    <circle cx="150" cy="50" r="40"/>
                                    <circle cx="50" cy="150" r="30"/>
                                </svg>
                            </div>
                            <div class="position-relative">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h1 class="display-6 fw-bold mb-3">Welcome back, {{ $user->name }}! 👋</h1>
                                        <p class="fs-5 mb-0 opacity-90">{{ now()->format('l, F j, Y') }} • Ready to build something amazing?</p>
                                    </div>
                                    @if(!$activeSubscription)
                                        <a href="{{ route('home') }}" class="btn btn-light btn-lg shadow-sm transition-hover-top">
                                            <i class="bi bi-rocket me-2"></i>
                                            Get Started
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Plan Status -->
                @if($activeSubscription)
                    <div class="card border-0 shadow-sm rounded-4 mb-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body p-5 text-white">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="bg-white bg-opacity-20 rounded-circle p-4 me-4">
                                            <i class="bi bi-star-fill fs-2"></i>
                                        </div>
                                        <div>
                                            <h2 class="fw-bold mb-2">{{ $activeSubscription->subscriptionPackage->name }} Plan</h2>
                                            <p class="mb-0 opacity-90 fs-5">{{ $activeSubscription->subscriptionPackage->description }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-3 flex-wrap">
                                        <span class="badge bg-success bg-opacity-90 rounded-pill px-4 py-2 fs-6">
                                            <i class="bi bi-check-circle me-2"></i>
                                            {{ ucfirst($activeSubscription->status) }}
                                        </span>
                                        <span class="badge bg-white bg-opacity-20 rounded-pill px-4 py-2 fs-6">
                                            <i class="bi bi-calendar me-2"></i>
                                            Expires {{ $activeSubscription->ends_at->format('M j, Y') }}
                                        </span>
                                        <span class="badge bg-white bg-opacity-20 rounded-pill px-4 py-2 fs-6">
                                            <i class="bi bi-arrow-repeat me-2"></i>
                                            {{ ucfirst($activeSubscription->billing_cycle) }} billing
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                                    <div class="d-flex flex-column align-items-md-end">
                                        <div class="display-4 fw-bold mb-2">
                                            @if($activeSubscription->price_paid > 0)
                                                ${{ number_format($activeSubscription->price_paid, 2) }}
                                            @else
                                                FREE
                                            @endif
                                        </div>
                                        <p class="mb-3 opacity-75 fs-5">
                                            per {{ $activeSubscription->billing_cycle === 'yearly' ? 'year' : 'month' }}
                                        </p>
                                        <a href="{{ route('home') }}" class="btn btn-light btn-lg shadow-sm transition-hover-top">
                                            <i class="bi bi-arrow-up-circle me-2"></i>
                                            Upgrade Plan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm rounded-4 mb-5" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                        <div class="card-body text-center py-5 px-4">
                            <div class="bg-white bg-opacity-30 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width:100px; height:100px;">
                                <i class="bi bi-rocket text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="fw-bold mb-3 text-dark">Ready to Launch? 🚀</h2>
                            <p class="text-dark mb-4 fs-5 px-3">Choose a plan that fits your needs and start building amazing applications with our powerful API services.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-5 py-3 transition-hover-top shadow-sm">
                                <i class="bi bi-box me-2"></i>
                                Explore All Plans
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Usage Statistics -->
                @if($activeSubscription)
                    <div class="row g-4 mb-5">
                        <div class="col-12 mb-3">
                            <h2 class="h4 fw-bold mb-2">📊 Overview</h2>
                            <p class="text-muted mb-0">Your API usage and account statistics at a glance</p>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card border-0 shadow-sm h-100 transition-hover-top" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="card-body p-4 text-center text-white">
                                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px;">
                                        <i class="bi bi-graph-up fs-3"></i>
                                    </div>
                                    <h3 class="display-6 fw-bold mb-2">{{ number_format($stats['total_api_calls']) }}</h3>
                                    <p class="mb-1 fw-medium">API Calls Used</p>
                                    <small class="opacity-75">
                                        <i class="bi bi-calendar me-1"></i>
                                        This month
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card border-0 shadow-sm h-100 transition-hover-top" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                <div class="card-body p-4 text-center text-white">
                                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px;">
                                        <i class="bi bi-speedometer2 fs-3"></i>
                                    </div>
                                    <h3 class="display-6 fw-bold mb-2">{{ number_format($stats['remaining_api_calls']) }}</h3>
                                    <p class="mb-1 fw-medium">Remaining Calls</p>
                                    <small class="opacity-75">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Available now
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card border-0 shadow-sm h-100 transition-hover-top" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="card-body p-4 text-center text-white">
                                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px;">
                                        <i class="bi bi-speedometer fs-3"></i>
                                    </div>
                                    <h3 class="display-6 fw-bold mb-2">{{ $stats['api_calls_limit'] ? number_format($stats['api_calls_limit']) : '∞' }}</h3>
                                    <p class="mb-1 fw-medium">Monthly Limit</p>
                                    <small class="opacity-75">
                                        <i class="bi bi-shield-check me-1"></i>
                                        Plan allowance
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card border-0 shadow-sm h-100 transition-hover-top" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                                <div class="card-body p-4 text-center text-dark">
                                    <div class="bg-white bg-opacity-60 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px;">
                                        <i class="bi bi-key fs-3 text-warning"></i>
                                    </div>
                                    <h3 class="display-6 fw-bold mb-2">{{ $stats['active_api_keys'] }}</h3>
                                    <p class="mb-1 fw-medium">Active API Keys</p>
                                    <small class="text-muted">
                                        <i class="bi bi-shield me-1"></i>
                                        Ready to use
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Usage Progress -->
                    @if($stats['api_calls_limit'])
                        <div class="card border-0 shadow-sm rounded-4 mb-5">
                            <div class="card-body p-5">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <div>
                                        <h3 class="fw-bold mb-2">📊 API Usage This Month</h3>
                                        <p class="text-muted mb-0">Track your monthly API consumption</p>
                                    </div>
                                    @php
                                        $usagePercent = $stats['api_calls_limit'] > 0 ? ($stats['total_api_calls'] / $stats['api_calls_limit']) * 100 : 0;
                                        $progressClass = $usagePercent >= 90 ? 'bg-danger' : ($usagePercent >= 70 ? 'bg-warning' : 'bg-success');
                                        $percentText = $usagePercent >= 90 ? 'text-danger' : ($usagePercent >= 70 ? 'text-warning' : 'text-success');
                                    @endphp
                                    <div class="text-end">
                                        <div class="display-6 fw-bold {{ $percentText }}">{{ number_format($usagePercent, 1) }}%</div>
                                        <small class="text-muted">used this month</small>
                                    </div>
                                </div>
                                
                                <div class="progress mb-4" style="height: 20px; background-color: #f8f9fa;">
                                    <div class="progress-bar {{ $progressClass }} rounded-3 shadow-sm" role="progressbar" style="width: {{ min($usagePercent, 100) }}%">
                                        <span class="fw-medium px-3">{{ number_format($stats['total_api_calls']) }} calls</span>
                                    </div>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="text-center p-3 bg-light rounded-3">
                                            <div class="fw-bold text-primary fs-4">{{ number_format($stats['total_api_calls']) }}</div>
                                            <small class="text-muted">Used</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center p-3 bg-light rounded-3">
                                            <div class="fw-bold text-success fs-4">{{ number_format($stats['remaining_api_calls']) }}</div>
                                            <small class="text-muted">Remaining</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center p-3 bg-light rounded-3">
                                            <div class="fw-bold text-info fs-4">{{ number_format($stats['api_calls_limit']) }}</div>
                                            <small class="text-muted">Total Limit</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <div class="row g-4">
                    <!-- API Keys -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-gradient-primary text-white border-0 rounded-top-4 d-flex justify-content-between align-items-center py-4">
                                <div>
                                    <h3 class="mb-1 fw-bold">🔑 API Keys</h3>
                                    <p class="mb-0 opacity-90">Manage your authentication keys</p>
                                </div>
                                @if($activeSubscription)
                                    <button class="btn btn-light btn-lg transition-hover-top" onclick="generateApiKey()">
                                        <i class="bi bi-plus-circle me-2"></i>
                                        Generate New
                                    </button>
                                @endif
                            </div>
                            <div class="card-body p-0">
                                @if($apiKeys->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover border-0 mb-0">
                                            <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                                <tr>
                                                    <th class="border-0 fw-bold px-4 py-3">Name</th>
                                                    <th class="border-0 fw-bold py-3">Key</th>
                                                    <th class="border-0 fw-bold py-3 text-center">Usage</th>
                                                    <th class="border-0 fw-bold py-3">Last Used</th>
                                                    <th class="border-0 fw-bold py-3 text-center">Status</th>
                                                    <th class="border-0 fw-bold py-3 text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($apiKeys as $apiKey)
                                                    <tr class="border-bottom">
                                                        <td class="border-0 px-4 py-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                                    <i class="bi bi-key text-primary"></i>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bold">{{ $apiKey->name }}</div>
                                                                    <small class="text-muted">Created {{ $apiKey->created_at->diffForHumans() }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="border-0 py-4">
                                                            <div class="d-flex align-items-center">
                                                                <code class="user-select-all bg-light p-2 rounded-3 me-2 border">{{ $apiKey->masked_key }}</code>
                                                                <button class="btn btn-sm btn-outline-primary transition-hover-top" onclick="copyToClipboard('{{ $apiKey->key }}')" title="Copy to clipboard">
                                                                    <i class="bi bi-clipboard"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        <td class="border-0 py-4 text-center">
                                                            <div class="fw-bold text-primary">{{ number_format($apiKey->usage_count) }}</div>
                                                            <small class="text-muted">calls</small>
                                                        </td>
                                                        <td class="border-0 py-4">
                                                            <span class="fw-medium">{{ $apiKey->last_used_at ? $apiKey->last_used_at->diffForHumans() : 'Never' }}</span>
                                                        </td>
                                                        <td class="border-0 py-4 text-center">
                                                            <span class="badge {{ $apiKey->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3 py-2">
                                                                <i class="bi {{ $apiKey->is_active ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                                                                {{ $apiKey->is_active ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </td>
                                                        <td class="border-0 py-4 text-center">
                                                            <button class="btn btn-sm {{ $apiKey->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} transition-hover-top" onclick="toggleApiKey({{ $apiKey->id }})">
                                                                <i class="bi {{ $apiKey->is_active ? 'bi-pause' : 'bi-play' }} me-1"></i>
                                                                {{ $apiKey->is_active ? 'Pause' : 'Activate' }}
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5 px-4">
                                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width:100px; height:100px;">
                                            <i class="bi bi-key text-muted" style="font-size: 2.5rem;"></i>
                                        </div>
                                        <h4 class="fw-bold mb-3">No API Keys Yet</h4>
                                        <p class="text-muted mb-4 px-3">
                                            @if($activeSubscription)
                                                Generate your first API key to start using our services and unlock the power of our APIs.
                                            @else
                                                Subscribe to a plan to get API keys and start building amazing applications.
                                            @endif
                                        </p>
                                        @if($activeSubscription)
                                            <button class="btn btn-primary btn-lg transition-hover-top" onclick="generateApiKey()">
                                                <i class="bi bi-plus-circle me-2"></i>
                                                Generate Your First Key
                                            </button>
                                        @else
                                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg transition-hover-top">
                                                <i class="bi bi-eye me-2"></i>
                                                View Plans
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions & Recent Activity -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-gradient-success text-white border-0 rounded-top-4 py-4">
                                <h3 class="mb-1 fw-bold">⚡ Quick Actions</h3>
                                <p class="mb-0 opacity-90">Fast access to common tasks</p>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-grid gap-3 mb-4">
                                    @if($activeSubscription)
                                        <button onclick="generateApiKey()" class="btn btn-primary btn-lg d-flex align-items-center justify-content-center transition-hover-top">
                                            <i class="bi bi-key me-2 fs-5"></i>
                                            <span class="fw-medium">Generate API Key</span>
                                        </button>
                                    @endif
                                    
                                    <a href="{{ route('dashboard.invoices') }}" class="btn btn-outline-primary btn-lg d-flex align-items-center justify-content-center transition-hover-top">
                                        <i class="bi bi-receipt me-2 fs-5"></i>
                                        <span class="fw-medium">View Invoices</span>
                                    </a>
                                    
                                    <a href="{{ route('home') }}" class="btn btn-outline-info btn-lg d-flex align-items-center justify-content-center transition-hover-top">
                                        <i class="bi bi-box me-2 fs-5"></i>
                                        <span class="fw-medium">Upgrade Plan</span>
                                    </a>
                                    
                                    <a href="{{ route('contact') }}" class="btn btn-outline-success btn-lg d-flex align-items-center justify-content-center transition-hover-top">
                                        <i class="bi bi-headset me-2 fs-5"></i>
                                        <span class="fw-medium">Get Support</span>
                                    </a>
                                </div>
                                
                                @if($recentInvoices->count() > 0)
                                    <div class="border-top pt-4">
                                        <h5 class="fw-bold mb-3 d-flex align-items-center">
                                            <i class="bi bi-clock-history me-2 text-muted"></i>
                                            Latest Invoice
                                        </h5>
                                        @php $latestInvoice = $recentInvoices->first() @endphp
                                        <div class="p-4 border rounded-4 bg-light">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <div class="fw-bold fs-5">{{ $latestInvoice->invoice_number }}</div>
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar me-1"></i>
                                                        {{ $latestInvoice->created_at->format('M j, Y') }}
                                                    </small>
                                                </div>
                                                <span class="badge {{ $latestInvoice->isPaid() ? 'bg-success' : ($latestInvoice->isOverdue() ? 'bg-danger' : 'bg-warning text-dark') }} rounded-pill px-3 py-2">
                                                    {{ ucfirst($latestInvoice->status) }}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="fs-4 fw-bold text-primary">${{ number_format($latestInvoice->total_amount, 2) }}</div>
                                                <a href="{{ route('dashboard.invoices') }}" class="btn btn-sm btn-outline-primary transition-hover-top">
                                                    <i class="bi bi-arrow-right me-1"></i>
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="border-top pt-4 text-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px;">
                                            <i class="bi bi-receipt text-primary fs-4"></i>
                                        </div>
                                        <h6 class="fw-bold mb-2">No Invoices Yet</h6>
                                        <p class="text-muted mb-0 small">Your billing history will appear here once you subscribe to a plan</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // You could add a toast notification here
        console.log('API key copied to clipboard');
    });
}

function generateApiKey() {
    // In a real implementation, this would make an AJAX request
    alert('API key generation feature would be implemented here');
}

function toggleApiKey(keyId) {
    // In a real implementation, this would make an AJAX request
    alert('API key toggle feature would be implemented here');
}
</script>
@endpush
@endsection