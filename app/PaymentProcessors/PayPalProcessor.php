<?php

namespace App\PaymentProcessors;

use App\Contracts\PaymentMethodSetupResponse;
use App\Contracts\PaymentRequest;
use App\Contracts\PaymentResponse;
use App\Contracts\WebhookResponse;
use App\PaymentMethodType;
use Illuminate\Support\Facades\Log;

class PayPalProcessor extends AbstractPaymentProcessor
{
    public function getName(): string
    {
        return 'paypal';
    }

    public function getSupportedTypes(): array
    {
        return [
            PaymentMethodType::PayPal,
        ];
    }

    public function validateConfig(array $config): bool
    {
        return isset($config['client_id']) && isset($config['client_secret']);
    }

    public function processPayment(PaymentRequest $request): PaymentResponse
    {
        Log::info("Processing PayPal payment for invoice {$request->invoice->id}");

        // Simulate PayPal API call
        $shouldSucceed = $this->simulatePaymentSuccess($request);

        if ($shouldSucceed) {
            return new PaymentResponse(
                success: true,
                transactionId: 'paypal_' . uniqid(),
                metadata: [
                    'processor' => 'paypal',
                    'payer_email' => $request->paymentMethod->metadata['email'] ?? 'user@example.com',
                    'amount' => $request->amount,
                ]
            );
        }

        return new PaymentResponse(
            success: false,
            errorMessage: 'PayPal payment failed',
            errorCode: 'paypal_declined',
            metadata: ['processor' => 'paypal']
        );
    }

    public function createPaymentMethod(array $data): PaymentMethodSetupResponse
    {
        Log::info('Creating PayPal payment method', $data);

        // For PayPal, we might need to redirect to PayPal for authorization
        $agreementId = 'B-' . uniqid();
        
        return new PaymentMethodSetupResponse(
            success: true,
            paymentMethodId: $agreementId,
            metadata: [
                'email' => $data['email'] ?? 'user@example.com',
                'agreement_id' => $agreementId,
            ],
            setupUrl: "https://sandbox.paypal.com/checkoutnow?token={$agreementId}",
            requiresVerification: true
        );
    }

    public function getWebhookEvents(): array
    {
        return [
            'PAYMENT.CAPTURE.COMPLETED',
            'PAYMENT.CAPTURE.DENIED',
            'BILLING.SUBSCRIPTION.ACTIVATED',
        ];
    }

    public function handleWebhook(string $event, array $payload): WebhookResponse
    {
        Log::info("Handling PayPal webhook: {$event}");

        switch ($event) {
            case 'PAYMENT.CAPTURE.COMPLETED':
                return WebhookResponse::handled('PayPal payment completed');
                
            case 'PAYMENT.CAPTURE.DENIED':
                return WebhookResponse::handled('PayPal payment denied');
                
            default:
                return WebhookResponse::notHandled();
        }
    }

    private function simulatePaymentSuccess(PaymentRequest $request): bool
    {
        // Simulate 85% success rate for PayPal
        return mt_rand(1, 100) <= 85;
    }
}