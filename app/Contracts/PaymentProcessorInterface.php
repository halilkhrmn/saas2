<?php

namespace App\Contracts;

use App\Models\PaymentMethod;

interface PaymentProcessorInterface
{
    /**
     * Get the processor name/identifier
     */
    public function getName(): string;

    /**
     * Get supported payment method types
     */
    public function getSupportedTypes(): array;

    /**
     * Validate payment method configuration
     */
    public function validateConfig(array $config): bool;

    /**
     * Process a payment
     */
    public function processPayment(PaymentRequest $request): PaymentResponse;

    /**
     * Create a payment method (for tokenization, setup, etc.)
     */
    public function createPaymentMethod(array $data): PaymentMethodSetupResponse;

    /**
     * Verify a payment method is still valid
     */
    public function verifyPaymentMethod(PaymentMethod $paymentMethod): bool;

    /**
     * Get webhook events this processor handles
     */
    public function getWebhookEvents(): array;

    /**
     * Handle webhook events
     */
    public function handleWebhook(string $event, array $payload): WebhookResponse;
}