<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\UserSubscription;

class InvoiceService
{
    public function createInvoiceForSubscription(UserSubscription $subscription): Invoice
    {
        $package = $subscription->subscriptionPackage;
        $taxRate = 0.08; // 8% tax rate
        $amount = $subscription->price_paid;
        $taxAmount = $amount * $taxRate;
        $totalAmount = $amount + $taxAmount;

        $lineItems = [
            [
                'description' => $package->name . ' Plan (' . ucfirst($subscription->billing_cycle) . ')',
                'quantity' => 1,
                'unit_price' => $amount,
                'total' => $amount,
            ],
        ];

        if ($taxAmount > 0) {
            $lineItems[] = [
                'description' => 'Tax',
                'quantity' => 1,
                'unit_price' => $taxAmount,
                'total' => $taxAmount,
            ];
        }

        return Invoice::create([
            'user_id' => $subscription->user_id,
            'user_subscription_id' => $subscription->id,
            'amount' => $amount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'currency' => 'USD',
            'status' => 'pending',
            'description' => 'Subscription to ' . $package->name . ' plan',
            'line_items' => $lineItems,
            'payment_methods' => ['credit_card', 'paypal', 'bank_transfer'],
            'due_date' => now()->addDays(7),
        ]);
    }

    public function calculateTax(float $amount, float $taxRate = 0.08): float
    {
        return $amount * $taxRate;
    }

    public function generateInvoiceNumber(): string
    {
        return Invoice::generateInvoiceNumber();
    }
}
