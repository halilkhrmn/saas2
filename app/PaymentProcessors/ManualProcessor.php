<?php

namespace App\PaymentProcessors;

use App\Contracts\PaymentMethodSetupResponse;
use App\Contracts\PaymentRequest;
use App\Contracts\PaymentResponse;
use App\PaymentMethodType;
use Illuminate\Support\Facades\Log;

class ManualProcessor extends AbstractPaymentProcessor
{
    public function getName(): string
    {
        return 'manual';
    }

    public function getSupportedTypes(): array
    {
        return [
            PaymentMethodType::BankTransfer,
            PaymentMethodType::Wallet,
        ];
    }

    public function processPayment(PaymentRequest $request): PaymentResponse
    {
        Log::info("Processing manual payment for invoice {$request->invoice->id}");

        // For manual payments, we mark them as pending and require admin approval
        return new PaymentResponse(
            success: true,
            transactionId: 'manual_' . uniqid(),
            metadata: [
                'processor' => 'manual',
                'requires_approval' => true,
                'payment_method' => $request->paymentMethod->type->value,
                'amount' => $request->amount,
                'instructions' => $this->getPaymentInstructions($request),
            ]
        );
    }

    public function createPaymentMethod(array $data): PaymentMethodSetupResponse
    {
        Log::info('Creating manual payment method', $data);

        // Manual payment methods are typically pre-configured
        $paymentMethodId = 'manual_' . uniqid();
        
        return new PaymentMethodSetupResponse(
            success: true,
            paymentMethodId: $paymentMethodId,
            metadata: [
                'account_number' => $data['account_number'] ?? '****1234',
                'bank_name' => $data['bank_name'] ?? 'Bank of Example',
                'account_holder' => $data['account_holder'] ?? 'User Name',
            ]
        );
    }

    private function getPaymentInstructions(PaymentRequest $request): string
    {
        switch ($request->paymentMethod->type) {
            case PaymentMethodType::BankTransfer:
                return "Please transfer {$request->amount} {$request->currency} to account: " . 
                       ($request->paymentMethod->metadata['account_number'] ?? 'Contact support');
                       
            case PaymentMethodType::Wallet:
                return "Payment will be processed from your wallet balance.";
                
            default:
                return "Manual payment processing required.";
        }
    }
}