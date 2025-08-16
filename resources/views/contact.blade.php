@extends('layouts.app')

@section('content')
<div class="section">
    <div class="container">
        <h1 class="display-5 fw-bold mb-5">
            How can we help?
        </h1>

        <div class="row g-xl-5">
            <div class="col-12 col-lg-8 mb-7">
                <!-- Map -->
                <div class="bg-white shadow-primary-xs rounded p-2 mb-5">
                    <div class="w-100 rounded bg-light d-flex align-items-center justify-content-center" style="height:450px">
                        <div class="text-center">
                            <svg class="text-muted mb-3" width="64" height="64" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12,2C8.13,2 5,5.13 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9C19,5.13 15.87,2 12,2M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5Z"/>
                            </svg>
                            <h5>{{ config('app.name') }} Headquarters</h5>
                            <p class="text-muted">Interactive map would be displayed here</p>
                        </div>
                    </div>
                </div>

                <h2 class="fw-bold mb-4">
                    Tell us about your project
                </h2>

                <!-- Contact Form -->
                <div class="bg-light p-4 p-lg-5 rounded">
                    @if(session('success'))
                        <div class="alert alert-success mb-4">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form novalidate action="{{ route('contact.submit') }}" method="POST" class="bs-validate">
                        @csrf

                        <div class="form-floating mb-3">
                            <input required placeholder="Name" id="contact_name" name="contact_name" type="text" class="form-control" value="{{ old('contact_name') }}">
                            <label for="contact_name">Name</label>
                            @error('contact_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input required placeholder="Email" id="contact_email" name="contact_email" type="email" class="form-control" value="{{ old('contact_email') }}">
                            <label for="contact_email">Email</label>
                            @error('contact_email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input placeholder="Phone" id="contact_phone" name="contact_phone" type="text" class="form-control" value="{{ old('contact_phone') }}">
                            <label for="contact_phone">Phone (Optional)</label>
                            @error('contact_phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <select required id="contact_subject" name="contact_subject" class="form-control">
                                <option value="">Choose a subject</option>
                                <option value="general" {{ old('contact_subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="support" {{ old('contact_subject') == 'support' ? 'selected' : '' }}>Technical Support</option>
                                <option value="billing" {{ old('contact_subject') == 'billing' ? 'selected' : '' }}>Billing Question</option>
                                <option value="partnership" {{ old('contact_subject') == 'partnership' ? 'selected' : '' }}>Partnership</option>
                                <option value="other" {{ old('contact_subject') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <label for="contact_subject">Subject</label>
                            @error('contact_subject')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <textarea required placeholder="Message" id="contact_message" name="contact_message" class="form-control" rows="3" style="min-height:120px">{{ old('contact_message') }}</textarea>
                            <label for="contact_message">Message</label>
                            @error('contact_message')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- GDPR CONSENT -->
                        <div class="mb-3 border p-3 rounded">
                            <p class="small mb-3 pb-3 border-bottom">
                                We respect your privacy and will only use your information to respond to your inquiry. 
                                Your data is handled according to our privacy policy.
                            </p>

                            <div class="form-check">
                                <input required class="form-check-input" id="contact_consent" name="contact_consent" type="checkbox" value="1" {{ old('contact_consent') ? 'checked' : '' }}>
                                <label class="form-check-label" for="contact_consent">
                                    I agree to the processing of my personal data for the purpose of responding to my inquiry.
                                </label>
                                @error('contact_consent')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- /GDPR CONSENT -->

                        <button type="submit" class="btn btn-primary w-100 transition-hover-top">
                            <i class="bi bi-send me-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-4 mb-3">
                <div class="sticky-top z-index-0" style="top:120px">
                    <!-- Company Info -->
                    <div class="d-flex mb-4">
                        <div class="float-none me-3">
                            <i class="fi fi-shape-abstract-dots text-gray-500 float-start fs-2"></i> 
                        </div>
                        <div>
                            <h2 class="fs-5">{{ config('app.name') }}</h2>
                            <ul class="list-unstyled m-0 fs-6"> 
                                <li class="list-item text-muted">Building powerful API solutions</li> 
                                <li class="list-item text-muted">Serving developers worldwide</li> 
                                <li class="mt-3 list-item text-muted">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    San Francisco, CA
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div class="d-flex mb-4">
                        <div class="float-none me-3">
                            <i class="fi fi-time text-gray-500 float-start fs-2"></i> 
                        </div>
                        <div>
                            <h2 class="fs-5">Business Hours</h2>
                            <ul class="list-unstyled m-0 fs-6">
                                <li class="list-item text-muted">Monday - Friday: 9:00 AM - 6:00 PM PST</li>
                                <li class="list-item text-muted">Saturday: 10:00 AM - 4:00 PM PST</li>
                                <li class="list-item text-muted">Sunday: Closed</li>
                                <li class="mt-3 list-item text-muted">
                                    <i class="bi bi-clock me-2"></i>
                                    Support available 24/7 for enterprise customers
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Contact Methods -->
                    <div class="d-flex mb-4">
                        <div class="float-none me-3">
                            <i class="fi fi-phone text-gray-500 float-start fs-2"></i> 
                        </div>
                        <div>
                            <h2 class="fs-5">Get in Touch</h2>
                            <ul class="list-unstyled m-0 fs-6">
                                <li class="list-item">
                                    <a href="mailto:support@{{ strtolower(str_replace(' ', '', config('app.name', 'apisaas'))) }}.com" class="text-decoration-none">
                                        <i class="bi bi-envelope me-2"></i>
                                        support@{{ strtolower(str_replace(' ', '', config('app.name', 'apisaas'))) }}.com
                                    </a>
                                </li>
                                <li class="list-item mt-2">
                                    <a href="tel:+1-555-0123" class="text-decoration-none">
                                        <i class="bi bi-telephone me-2"></i>
                                        +1 (555) 012-3456
                                    </a>
                                </li>
                                <li class="list-item mt-3">
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle">
                                            <i class="bi bi-twitter"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle">
                                            <i class="bi bi-linkedin"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle">
                                            <i class="bi bi-github"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-light p-4 rounded">
                        <h5 class="fw-bold mb-3">Quick Links</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center">
                                    <i class="bi bi-arrow-right me-2 text-primary"></i>
                                    API Pricing
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none d-flex align-items-center">
                                    <i class="bi bi-arrow-right me-2 text-primary"></i>
                                    Documentation
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none d-flex align-items-center">
                                    <i class="bi bi-arrow-right me-2 text-primary"></i>
                                    Status Page
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none d-flex align-items-center">
                                    <i class="bi bi-arrow-right me-2 text-primary"></i>
                                    Privacy Policy
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection