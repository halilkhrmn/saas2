<?php

namespace App\Contracts;

class PaymentMethodSetupResponse
{
    public function __construct(
        public readonly bool $success,
        public readonly ?string $paymentMethodId = null,
        public readonly ?array $metadata = null,
        public readonly ?string $errorMessage = null,
        public readonly ?string $setupUrl = null, // For redirects (like 3D Secure)
        public readonly bool $requiresVerification = false
    ) {}

    public function isSuccessful(): bool
    {
        return $this->success;
    }

    public function requiresRedirect(): bool
    {
        return $this->setupUrl !== null;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'payment_method_id' => $this->paymentMethodId,
            'metadata' => $this->metadata,
            'error_message' => $this->errorMessage,
            'setup_url' => $this->setupUrl,
            'requires_verification' => $this->requiresVerification,
        ];
    }
}