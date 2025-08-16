<?php

namespace App\Services;

use App\Contracts\PaymentProcessorInterface;
use App\PaymentMethodType;
use App\PaymentProcessors\ManualProcessor;
use App\PaymentProcessors\PayPalProcessor;
use App\PaymentProcessors\StripeProcessor;
use Illuminate\Support\Collection;

class PaymentProcessorRegistry
{
    protected array $processors = [];
    
    protected array $defaultMappings = [
        'stripe' => StripeProcessor::class,
        'paypal' => PayPalProcessor::class,
        'manual' => ManualProcessor::class,
    ];

    public function __construct()
    {
        $this->loadDefaultProcessors();
    }

    public function register(string $name, string $processorClass, array $config = []): void
    {
        if (!is_subclass_of($processorClass, PaymentProcessorInterface::class)) {
            throw new \InvalidArgumentException("Processor must implement PaymentProcessorInterface");
        }

        $this->processors[$name] = [
            'class' => $processorClass,
            'config' => $config,
        ];
    }

    public function get(string $name): PaymentProcessorInterface
    {
        if (!isset($this->processors[$name])) {
            throw new \InvalidArgumentException("Payment processor '{$name}' not found");
        }

        $processor = $this->processors[$name];
        return new $processor['class']($processor['config']);
    }

    public function getProcessorForPaymentMethodType(PaymentMethodType $type): PaymentProcessorInterface
    {
        foreach ($this->processors as $name => $processorData) {
            $processor = $this->get($name);
            
            if (in_array($type, $processor->getSupportedTypes())) {
                return $processor;
            }
        }

        throw new \InvalidArgumentException("No processor found for payment method type: {$type->value}");
    }

    public function getProcessorForProvider(string $provider): PaymentProcessorInterface
    {
        return $this->get($provider);
    }

    public function getAvailableProcessors(): array
    {
        return array_keys($this->processors);
    }

    public function getSupportedTypesForProcessor(string $name): array
    {
        return $this->get($name)->getSupportedTypes();
    }

    public function getAllSupportedTypes(): Collection
    {
        $types = collect();
        
        foreach ($this->processors as $name => $processorData) {
            $processor = $this->get($name);
            $types = $types->merge($processor->getSupportedTypes());
        }

        return $types->unique();
    }

    protected function loadDefaultProcessors(): void
    {
        foreach ($this->defaultMappings as $name => $class) {
            $config = config("payment.processors.{$name}", []);
            $this->register($name, $class, $config);
        }
    }

    public function getProcessorCapabilities(): array
    {
        $capabilities = [];
        
        foreach ($this->processors as $name => $processorData) {
            $processor = $this->get($name);
            $capabilities[$name] = [
                'name' => $processor->getName(),
                'supported_types' => array_map(
                    fn($type) => $type->value, 
                    $processor->getSupportedTypes()
                ),
                'webhook_events' => $processor->getWebhookEvents(),
            ];
        }

        return $capabilities;
    }
}