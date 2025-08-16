<?php

namespace App\PaymentProcessors;

use App\Contracts\PaymentProcessorInterface;
use App\Contracts\WebhookResponse;
use App\Models\PaymentMethod;

abstract class AbstractPaymentProcessor implements PaymentProcessorInterface
{
    protected array $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function validateConfig(array $config): bool
    {
        return true;
    }

    public function verifyPaymentMethod(PaymentMethod $paymentMethod): bool
    {
        return $paymentMethod->isActive();
    }

    public function getWebhookEvents(): array
    {
        return [];
    }

    public function handleWebhook(string $event, array $payload): WebhookResponse
    {
        return WebhookResponse::notHandled('Event not supported');
    }

    protected function getConfig(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }
}