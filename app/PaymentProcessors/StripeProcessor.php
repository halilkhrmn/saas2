<?php

namespace App\PaymentProcessors;

use App\Contracts\PaymentMethodSetupResponse;
use App\Contracts\PaymentRequest;
use App\Contracts\PaymentResponse;
use App\Contracts\WebhookResponse;
use App\PaymentMethodType;
use Illuminate\Support\Facades\Log;

class StripeProcessor extends AbstractPaymentProcessor
{
    public function getName(): string
    {
        return 'stripe';
    }

    public function getSupportedTypes(): array
    {
        return [
            PaymentMethodType::CreditCard,
            PaymentMethodType::DebitCard,
        ];
    }

    public function validateConfig(array $config): bool
    {
        return isset($config['secret_key']) && isset($config['publishable_key']);
    }

    public function processPayment(PaymentRequest $request): PaymentResponse
    {
        Log::info("Processing Stripe payment for invoice {$request->invoice->id}");

        // Simulate Stripe API call
        $shouldSucceed = $this->simulatePaymentSuccess($request);

        if ($shouldSucceed) {
            return new PaymentResponse(
                success: true,
                transactionId: 'stripe_' . uniqid(),
                metadata: [
                    'processor' => 'stripe',
                    'card_last_four' => $request->paymentMethod->metadata['last_four'] ?? '****',
                    'amount_cents' => $request->amount * 100,
                ]
            );
        }

        return new PaymentResponse(
            success: false,
            errorMessage: 'Card was declined',
            errorCode: 'card_declined',
            metadata: ['processor' => 'stripe']
        );
    }

    public function createPaymentMethod(array $data): PaymentMethodSetupResponse
    {
        Log::info('Creating Stripe payment method', $data);

        // Simulate card tokenization
        $token = 'pm_' . uniqid();
        
        return new PaymentMethodSetupResponse(
            success: true,
            paymentMethodId: $token,
            metadata: [
                'last_four' => $data['card_number'] ? substr($data['card_number'], -4) : '1234',
                'brand' => $data['brand'] ?? 'visa',
                'exp_month' => $data['exp_month'] ?? '12',
                'exp_year' => $data['exp_year'] ?? '2025',
            ]
        );
    }

    public function getWebhookEvents(): array
    {
        return [
            'payment_intent.succeeded',
            'payment_intent.payment_failed',
            'payment_method.attached',
        ];
    }

    public function handleWebhook(string $event, array $payload): WebhookResponse
    {
        Log::info("Handling Stripe webhook: {$event}");

        switch ($event) {
            case 'payment_intent.succeeded':
                return WebhookResponse::handled('Payment confirmed');
                
            case 'payment_intent.payment_failed':
                return WebhookResponse::handled('Payment failed');
                
            default:
                return WebhookResponse::notHandled();
        }
    }

    private function simulatePaymentSuccess(PaymentRequest $request): bool
    {
        // Simulate 90% success rate
        return mt_rand(1, 100) <= 90;
    }
}