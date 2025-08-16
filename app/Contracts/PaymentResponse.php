<?php

namespace App\Contracts;

class PaymentResponse
{
    public function __construct(
        public readonly bool $success,
        public readonly ?string $transactionId = null,
        public readonly ?string $errorMessage = null,
        public readonly ?string $errorCode = null,
        public readonly array $metadata = []
    ) {}

    public function isSuccessful(): bool
    {
        return $this->success;
    }

    public function isFailed(): bool
    {
        return !$this->success;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'transaction_id' => $this->transactionId,
            'error_message' => $this->errorMessage,
            'error_code' => $this->errorCode,
            'metadata' => $this->metadata,
        ];
    }
}