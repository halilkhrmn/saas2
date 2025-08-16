@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-credit-card me-2"></i>
                        Complete Your Purchase
                    </h4>
                </div>
                
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="fw-bold mb-3">Order Summary</h5>
                            
                            <div class="border rounded p-4 mb-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="fw-bold">{{ $package->name }} Plan</h6>
                                        <p class="text-muted mb-0">{{ $package->description }}</p>
                                        <small class="text-muted">
                                            Billing: {{ ucfirst($billingCycle) }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold fs-4">
                                            @if($price > 0)
                                                ${{ number_format($price, 2) }}
                                                <small class="text-muted fs-6">/{{ $billingCycle === 'yearly' ? 'year' : 'month' }}</small>
                                            @else
                                                Free
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <ul class="list-unstyled mb-0">
                                    @foreach($package->features as $feature)
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            @if($price > 0)
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>What happens next:</strong>
                                    <ol class="mb-0 mt-2">
                                        <li>We'll create an invoice for your subscription</li>
                                        <li>You'll be redirected to the payment page</li>
                                        <li>Once payment is completed, your subscription becomes active</li>
                                        <li>You'll receive an API key to start using our services</li>
                                    </ol>
                                </div>
                            @else
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle me-2"></i>
                                    <strong>Free Plan Benefits:</strong>
                                    Your free plan will be activated immediately and you'll receive an API key to get started!
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-4">
                            <div class="bg-light rounded p-4">
                                <h6 class="fw-bold mb-3">Billing Details</h6>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($price, 2) }}</span>
                                </div>
                                
                                @if($price > 0)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Tax (8%):</span>
                                        <span>${{ number_format($price * 0.08, 2) }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total:</span>
                                        <span>${{ number_format($price * 1.08, 2) }}</span>
                                    </div>
                                @else
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total:</span>
                                        <span>Free</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <form method="POST" action="{{ route('subscription.purchase', $package->slug) }}">
                        @csrf
                        <input type="hidden" name="billing_cycle" value="{{ $billingCycle }}">
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>
                                Back to Pricing
                            </a>
                            
                            <button type="submit" class="btn btn-primary btn-lg">
                                @if($price > 0)
                                    <i class="bi bi-credit-card me-2"></i>
                                    Proceed to Payment
                                @else
                                    <i class="bi bi-check-circle me-2"></i>
                                    Activate Free Plan
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection