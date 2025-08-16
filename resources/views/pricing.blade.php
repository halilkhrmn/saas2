@extends('layouts.app')

@section('content')
<!-- INTRO -->
<div class="section min-vh-75 bg-gradient-primary text-white">
    <div class="container mt-5">
        <div class="row w-100 d-middle">
            <div class="col-12 col-lg-6 text-xs-center">
                <h1 class="display-4 mb-3 fw-bold">
                    <span class="d-block h2 mb-0">
                        Amazing developers deserve
                    </span>
                    <span class="d-block mb-0">
                        amazing API services
                    </span>
                </h1>
                <p>
                    The simplest way to scale in the cloud! <br>
                    Start in one step now, no credit card required.
                </p>
                <a href="#pricing" class="btn btn-lg btn-warning bg-gradient-warning transition-hover-top shadow-none mt-5">
                    <span class="fw-medium">Start Now</span> &ndash; It's Free
                </a>
            </div>
            <!-- image -->
            <div class="col-12 col-lg-6 text-center">
                <svg class="w-100" style="max-width: 500px;" viewBox="0 0 500 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="50" y="100" width="400" height="250" rx="20" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                    <circle cx="100" cy="150" r="30" fill="rgba(255,255,255,0.2)"/>
                    <rect x="150" y="130" width="200" height="8" rx="4" fill="rgba(255,255,255,0.3)"/>
                    <rect x="150" y="150" width="150" height="8" rx="4" fill="rgba(255,255,255,0.2)"/>
                    <rect x="80" y="200" width="340" height="120" rx="10" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.2)"/>
                    <text x="250" y="260" text-anchor="middle" fill="rgba(255,255,255,0.8)" font-size="24" font-weight="bold">API Dashboard</text>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- svg shape -->
    <svg class="position-absolute bottom-0 start-0 end-0" viewBox="0 0 1200 120" style="transform: rotate(180deg) rotateY(180deg);">
        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" fill="#ffffff"></path>
    </svg>
</div>

<!-- Pricing Section -->
<div class="section" id="pricing">
    <div class="container"> 
        <div class="py-6" data-aos="fade-in" data-aos-delay="0" data-aos-offset="0">
            <div class="text-center mb-7">
@if($activeSubscription)
                    <h2 class="display-5 fw-bold mb-4">Upgrade Your Plan</h2>
                    <p class="lead text-muted max-w-450 mx-auto">
                        You're currently on the <strong class="text-success">{{ $currentPackage->name }}</strong> plan. 
                        Upgrade to unlock more features and higher limits!
                    </p>
                @else
                    <h2 class="display-5 fw-bold mb-4">Choose Your Plan</h2>
                    <p class="lead text-muted max-w-450 mx-auto">Start free, upgrade as you grow. The simplest way to scale in the cloud!</p>
                @endif
            </div>

            <div class="row g-4 justify-content-center">
                @forelse($packages as $package)
                    <div class="col-lg-4 col-md-6">
                        @php
                            $isCurrentPlan = $package->isCurrentPackage($currentPackage);
                            $canUpgrade = $package->canUpgradeFrom($currentPackage);
                            $isPopular = $package->slug === 'professional'; // En popüler plan olarak işaretle
                        @endphp
                        
                        <div class="card h-100 {{ $isPopular ? 'border-primary shadow-primary' : 'border-0 shadow-primary-xs' }} {{ $isCurrentPlan ? 'border-success' : '' }} transition-hover-top position-relative">
                            @if($isPopular)
                                <div class="position-absolute top-0 start-50 translate-middle">
                                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill">Most Popular</span>
                                </div>
                            @endif
                            
                            @if($isCurrentPlan)
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-success text-white px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Current Plan
                                    </span>
                                </div>
                            @endif
                            
                            <div class="card-body p-5 text-center {{ $isPopular ? 'pt-6' : '' }}">
                                <div class="mb-4">
                                    <div class="{{ $package->slug === 'enterprise' ? 'bg-gradient-dark' : 'bg-gradient-primary' }} rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px; height:80px;">
                                        @if($package->slug === 'free')
                                            <svg width="45" fill="#ffffff" viewBox="0 0 24 24">
                                                <path d="M12 2L2 7V10C2 16 6 20.9 12 22C18 20.9 22 16 22 10V7L12 2Z"/>
                                            </svg>
                                        @elseif($package->slug === 'professional')
                                            <svg width="45" fill="#ffffff" viewBox="0 0 24 24">
                                                <path d="M12 2L13.09 8.26L22 9L16 14.74L17.18 22L12 19.77L6.82 22L8 14.74L2 9L10.91 8.26L12 2Z"/>
                                            </svg>
                                        @elseif($package->slug === 'enterprise')
                                            <svg width="45" fill="#ffffff" viewBox="0 0 24 24">
                                                <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11H16V16H8V11H9.2V10C9.2,8.6 10.6,7 12,7M12,8.2C11.2,8.2 10.4,8.7 10.4,10V11H13.6V10C13.6,8.7 12.8,8.2 12,8.2Z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <h3 class="h2 fw-bold {{ $isCurrentPlan ? 'text-success' : ($package->slug === 'professional' ? 'text-primary' : '') }}">{{ $package->name }}</h3>
                                    <div class="mb-3">
                                        <span class="display-4 fw-bold {{ $package->slug === 'enterprise' ? 'text-dark' : 'text-primary' }}">
                                            {{ $package->monthly_price > 0 ? '$' . number_format($package->monthly_price, 0) : 'FREE' }}
                                        </span>
                                        @if($package->monthly_price > 0)
                                            <span class="text-muted">/month</span>
                                        @endif
                                    </div>
                                    @if($package->yearly_price > 0 && $package->yearly_price < ($package->monthly_price * 12))
                                        <div class="mb-3">
                                            <small class="text-success fw-medium">
                                                ${{ number_format($package->yearly_price, 0) }}/year 
                                                (save ${{ number_format(($package->monthly_price * 12) - $package->yearly_price, 0) }})
                                            </small>
                                        </div>
                                    @endif
                                    <p class="text-muted">{{ $package->description }}</p>
                                </div>
                                
                                @if($package->features)
                                    <ul class="list-unstyled mb-5 text-start">
                                        @foreach($package->features as $feature)
                                            <li class="mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                {{ $feature }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                
                                @if($isCurrentPlan)
                                    <button disabled class="btn btn-success btn-lg w-100 mb-2">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Current Plan
                                    </button>
                                @elseif($activeSubscription && !$canUpgrade)
                                    <button disabled class="btn btn-secondary btn-lg w-100 mb-2">
                                        <i class="bi bi-lock me-2"></i>
                                        Downgrade Not Available
                                    </button>
                                    <small class="text-muted">Contact support for downgrades</small>
                                @else
                                    @if($package->monthly_price > 0)
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <button onclick="selectPlan('{{ $package->slug }}', 'monthly')" class="btn {{ $package->slug === 'enterprise' ? 'btn-dark' : 'btn-primary' }} btn-lg w-100 transition-hover-top">
                                                    @if($activeSubscription && $canUpgrade)
                                                        Upgrade
                                                    @else
                                                        ${{ number_format($package->monthly_price, 0) }}/mo
                                                    @endif
                                                </button>
                                            </div>
                                            @if($package->yearly_price > 0)
                                                <div class="col-6">
                                                    <button onclick="selectPlan('{{ $package->slug }}', 'yearly')" class="btn {{ $package->slug === 'enterprise' ? 'btn-outline-dark' : 'btn-outline-primary' }} btn-lg w-100 transition-hover-top">
                                                        @if($activeSubscription && $canUpgrade)
                                                            Year
                                                        @else
                                                            ${{ number_format($package->yearly_price, 0) }}/yr
                                                        @endif
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <button onclick="selectPlan('{{ $package->slug }}', 'monthly')" class="btn btn-outline-primary btn-lg w-100 transition-hover-top">
                                            @if($activeSubscription)
                                                Switch to Free
                                            @else
                                                Get Started
                                            @endif
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No subscription packages available at the moment.</p>
                    </div>
                @endforelse
            </div>

            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="section border-top">
    <div class="container">
        <h2 class="display-5 fw-bold mb-4 text-center mb-7">
            Why Choose Our API?
        </h2>

        <div class="row g-4 border-top pt-5 mt-5">
            <div class="col-6 col-md-4">
                <!-- icon -->
                <div style="width:80px; height:80px;" class="rounded-circle bg-gradient-primary d-inline-flex align-items-center justify-content-center">
                    <svg width="45" fill="#ffffff" viewBox="0 0 24 24">
                        <path d="M13 2.05V3.0L15.85 5.85L16.55 5.15L18.1 6.7L16.85 7.95L18.95 10.05L20.5 8.5L22.05 10.05L19.6 12.5L18.35 11.25L16.25 13.35L14.7 11.8L15.4 11.1L12.55 8.25L8.95 4.65L7.4 3.1L8.95 1.55L10.5 3.1L13 0.6L14.55 2.15L13 3.7L14.3 5H13V2.05M12 21L3 11L7.41 6.59L18.7 17.88L14.29 22.29L12 21M5.83 11L12 17.17L16.17 13L10 6.83L5.83 11Z"/>
                    </svg>
                </div>

                <h2 class="h4 my-3">Fast & Reliable</h2>
                <p>99.9% uptime with lightning-fast response times. Built for mission-critical applications.</p>
            
            </div>

            <div class="col-6 col-md-4">
                <!-- icon -->
                <div style="width:80px; height:80px;" class="rounded-circle bg-gradient-primary d-inline-flex align-items-center justify-content-center">
                    <svg width="45" fill="#ffffff" viewBox="0 0 24 24">
                        <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11H16V16H8V11H9.2V10C9.2,8.6 10.6,7 12,7M12,8.2C11.2,8.2 10.4,8.7 10.4,10V11H13.6V10C13.6,8.7 12.8,8.2 12,8.2Z"/>
                    </svg>
                </div>

                <h2 class="h4 my-3">Secure</h2>
                <p>Enterprise-grade security with encrypted connections and comprehensive data protection.</p>
            
            </div>

            <div class="col-12 col-md-4 text-center-xs">
                <!-- icon -->
                <div style="width:80px; height:80px;" class="rounded-circle bg-gradient-primary d-inline-flex align-items-center justify-content-center">
                    <svg width="45" fill="#ffffff" viewBox="0 0 24 24">
                        <path d="M16,6L18.29,8.29L13.41,13.17L9.41,9.17L2,16.59L3.41,18L9.41,12L13.41,16L19.71,9.71L22,12V6H16Z"/>
                    </svg>
                </div>

                <h2 class="h4 my-3">Scalable</h2>
                <p>Scale from thousands to millions of requests seamlessly with our auto-scaling infrastructure.</p>
            
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function selectPlan(planName, billingCycle) {
    @auth
        // User is logged in, redirect to purchase
        window.location.href = `/subscription/buy/${planName}?cycle=${billingCycle}`;
    @else
        // User needs to login first, store intended URL
        sessionStorage.setItem('intendedPlan', planName);
        sessionStorage.setItem('intendedCycle', billingCycle);
        window.location.href = '{{ route("login") }}';
    @endauth
}

// Check if user just logged in and has an intended plan
@auth
document.addEventListener('DOMContentLoaded', function() {
    const intendedPlan = sessionStorage.getItem('intendedPlan');
    const intendedCycle = sessionStorage.getItem('intendedCycle');
    
    if (intendedPlan && intendedCycle) {
        sessionStorage.removeItem('intendedPlan');
        sessionStorage.removeItem('intendedCycle');
        window.location.href = `/subscription/buy/${intendedPlan}?cycle=${intendedCycle}`;
    }
});
@endauth
</script>
@endpush
@endsection