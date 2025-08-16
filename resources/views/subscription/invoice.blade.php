@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-receipt me-2"></i>
                            Invoice {{ $invoice->invoice_number }}
                        </h4>
                        <span class="badge {{ $invoice->isPaid() ? 'bg-success' : ($invoice->isOverdue() ? 'bg-danger' : 'bg-warning text-dark') }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </div>
                </div>
                
                <div class="card-body p-5">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Bill To:</h6>
                            <p class="mb-0">{{ $invoice->user->name }}</p>
                            <p class="text-muted">{{ $invoice->user->email }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="fw-bold">Invoice Details:</h6>
                            <p class="mb-1"><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
                            <p class="mb-1"><strong>Date:</strong> {{ $invoice->created_at->format('M j, Y') }}</p>
                            <p class="mb-1"><strong>Due Date:</strong> {{ $invoice->due_date->format('M j, Y') }}</p>
                            @if($invoice->paid_at)
                                <p class="mb-0"><strong>Paid:</strong> {{ $invoice->paid_at->format('M j, Y g:i A') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Unit Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->line_items as $item)
                                    <tr>
                                        <td>{{ $item['description'] }}</td>
                                        <td class="text-center">{{ $item['quantity'] }}</td>
                                        <td class="text-end">${{ number_format($item['unit_price'], 2) }}</td>
                                        <td class="text-end">${{ number_format($item['total'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Subtotal:</td>
                                    <td class="text-end">${{ number_format($invoice->amount, 2) }}</td>
                                </tr>
                                @if($invoice->tax_amount > 0)
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Tax:</td>
                                        <td class="text-end">${{ number_format($invoice->tax_amount, 2) }}</td>
                                    </tr>
                                @endif
                                <tr class="table-primary">
                                    <td colspan="3" class="text-end fw-bold fs-5">Total:</td>
                                    <td class="text-end fw-bold fs-5">${{ number_format($invoice->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if(!$invoice->isPaid())
                        <div class="alert alert-info mb-4">
                            <h6 class="alert-heading">
                                <i class="bi bi-info-circle me-2"></i>
                                Payment Methods
                            </h6>
                            <p class="mb-0">This is a demo application. Click "Pay Now" to simulate a successful payment.</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Available Payment Methods:</h6>
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <i class="bi bi-credit-card me-2 text-primary"></i>
                                        Credit Card
                                        <small class="text-muted d-block">Visa, MasterCard, American Express</small>
                                    </div>
                                    <div class="list-group-item">
                                        <i class="bi bi-paypal me-2 text-info"></i>
                                        PayPal
                                        <small class="text-muted d-block">Pay with your PayPal account</small>
                                    </div>
                                    <div class="list-group-item">
                                        <i class="bi bi-bank me-2 text-success"></i>
                                        Bank Transfer
                                        <small class="text-muted d-block">Direct bank transfer</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>
                                Back to Dashboard
                            </a>
                            
                            <form method="POST" action="{{ route('subscription.pay', $invoice) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-credit-card me-2"></i>
                                    Pay Now - ${{ number_format($invoice->total_amount, 2) }}
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <h6 class="alert-heading">
                                <i class="bi bi-check-circle me-2"></i>
                                Payment Completed
                            </h6>
                            <p class="mb-0">This invoice has been paid in full on {{ $invoice->paid_at->format('M j, Y g:i A') }}.</p>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Go to Dashboard
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection