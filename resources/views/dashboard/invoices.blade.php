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
                                            {{ Auth::user()->name }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
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
                            <li class="nav-item active">
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
                <div class="card border-0 shadow-primary-xs">
                    <div class="card-header bg-white border-bottom py-4">
                        <h2 class="h4 mb-0 fw-bold">
                            <i class="bi bi-receipt me-2 text-primary"></i>
                            Invoices
                        </h2>
                        <p class="text-muted mb-0">Manage your billing and payment history</p>
                    </div>
                    <div class="card-body p-0">
                        @if(isset($invoices) && $invoices->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover border-0 mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 fw-bold px-4">Invoice #</th>
                                            <th class="border-0 fw-bold">Date</th>
                                            <th class="border-0 fw-bold">Amount</th>
                                            <th class="border-0 fw-bold">Status</th>
                                            <th class="border-0 fw-bold">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoices as $invoice)
                                            <tr>
                                                <td class="border-0 px-4 fw-medium">{{ $invoice->invoice_number }}</td>
                                                <td class="border-0">{{ $invoice->created_at->format('M j, Y') }}</td>
                                                <td class="border-0 fw-bold">${{ number_format($invoice->total_amount, 2) }}</td>
                                                <td class="border-0">
                                                    <span class="badge {{ $invoice->isPaid() ? 'bg-success' : ($invoice->isOverdue() ? 'bg-danger' : 'bg-warning text-dark') }} rounded-pill">
                                                        {{ ucfirst($invoice->status) }}
                                                    </span>
                                                </td>
                                                <td class="border-0">
                                                    <div class="d-flex gap-2">
                                                        <a href="#" class="btn btn-sm btn-outline-primary transition-hover-top">
                                                            <i class="bi bi-eye me-1"></i>
                                                            View
                                                        </a>
                                                        <a href="#" class="btn btn-sm btn-outline-secondary transition-hover-top">
                                                            <i class="bi bi-download me-1"></i>
                                                            Download
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 px-4">
                                <svg class="text-muted mb-3" width="64" height="64" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                </svg>
                                <h5>No Invoices Yet</h5>
                                <p class="text-muted mb-4">You don't have any invoices yet. Once you subscribe to a plan, your invoices will appear here.</p>
                                <a href="{{ route('home') }}" class="btn btn-primary transition-hover-top">
                                    <i class="bi bi-plus-circle me-2"></i>
                                    View Plans
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection