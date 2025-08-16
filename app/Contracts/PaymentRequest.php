<?php

namespace App\Contracts;

use App\Models\Invoice;
use App\Models\PaymentMethod;

class PaymentRequest
{
    public function __construct(
        public readonly Invoice $invoice,
        public readonly PaymentMethod $paymentMethod,
        public readonly float $amount,
        public readonly string $currency = 'USD',
        public readonly array $metadata = []
    ) {}

    public function toArray(): array
    {
        return [
            'invoice_id' => $this->invoice->id,
            'payment_method_id' => $this->paymentMethod->id,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'metadata' => $this->metadata,
        ];
    }
}