<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\PaymentMethodType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(PaymentMethodType::cases());
        
        return [
            'user_id' => User::factory(),
            'type' => $type,
            'name' => $this->generateNameForType($type),
            'provider' => $this->generateProviderForType($type),
            'provider_payment_method_id' => 'pm_' . $this->faker->unique()->numerify('##########'),
            'metadata' => $this->generateMetadataForType($type),
            'priority' => $this->faker->numberBetween(1, 10),
            'is_enabled' => $this->faker->boolean(90),
            'is_default' => $this->faker->boolean(20),
            'verified_at' => $this->faker->optional(0.8)->dateTimeBetween('-30 days', 'now'),
            'last_used_at' => $this->faker->optional(0.6)->dateTimeBetween('-30 days', 'now'),
        ];
    }
    
    private function generateNameForType(PaymentMethodType $type): string
    {
        return match ($type) {
            PaymentMethodType::CreditCard, PaymentMethodType::DebitCard => 
                $this->faker->creditCardType() . ' ending in ' . $this->faker->numerify('####'),
            PaymentMethodType::PayPal => 
                'PayPal (' . $this->faker->email() . ')',
            PaymentMethodType::BankTransfer => 
                $this->faker->company() . ' Bank Account',
            PaymentMethodType::Wallet => 
                $this->faker->randomElement(['Apple Pay', 'Google Pay', 'Samsung Pay']),
            PaymentMethodType::Cryptocurrency => 
                $this->faker->randomElement(['Bitcoin', 'Ethereum', 'USDC']) . ' Wallet',
            default => $type->label(),
        };
    }
    
    private function generateProviderForType(PaymentMethodType $type): string
    {
        return match ($type) {
            PaymentMethodType::CreditCard, PaymentMethodType::DebitCard => 'stripe',
            PaymentMethodType::PayPal => 'paypal',
            PaymentMethodType::BankTransfer => 'bank',
            PaymentMethodType::Wallet => 'apple_pay',
            PaymentMethodType::Cryptocurrency => 'coinbase',
            default => 'stripe',
        };
    }
    
    private function generateMetadataForType(PaymentMethodType $type): array
    {
        return match ($type) {
            PaymentMethodType::CreditCard, PaymentMethodType::DebitCard => [
                'last_4' => $this->faker->numerify('####'),
                'brand' => $this->faker->creditCardType(),
                'exp_month' => $this->faker->numberBetween(1, 12),
                'exp_year' => $this->faker->numberBetween(2025, 2030),
            ],
            PaymentMethodType::PayPal => [
                'email' => $this->faker->email(),
            ],
            PaymentMethodType::BankTransfer => [
                'account_type' => $this->faker->randomElement(['checking', 'savings']),
                'last_4' => $this->faker->numerify('####'),
            ],
            default => [],
        };
    }
}
