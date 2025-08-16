<?php

namespace App\Contracts;

class WebhookResponse
{
    public function __construct(
        public readonly bool $handled,
        public readonly ?string $message = null,
        public readonly array $data = []
    ) {}

    public function wasHandled(): bool
    {
        return $this->handled;
    }

    public static function handled(string $message = null, array $data = []): self
    {
        return new self(true, $message, $data);
    }

    public static function notHandled(string $message = null): self
    {
        return new self(false, $message);
    }
}