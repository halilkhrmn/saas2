<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\UserSubscription;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = $this->faker->randomFloat(2, 10, 500);
        $taxAmount = $amount * 0.18; // 18% tax
        $totalAmount = $amount + $taxAmount;
        
        return [
            'invoice_number' => 'INV-' . $this->faker->unique()->numerify('######'),
            'user_id' => User::factory(),
            'user_subscription_id' => UserSubscription::factory(),
            'amount' => $amount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'currency' => 'USD',
            'status' => $this->faker->randomElement(['pending', 'paid', 'failed', 'cancelled']),
            'description' => $this->faker->sentence(),
            'line_items' => [
                [
                    'description' => 'Subscription Fee',
                    'amount' => $amount,
                    'quantity' => 1,
                ]
            ],
            'payment_methods' => ['stripe'],
            'due_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'paid_at' => $this->faker->optional(0.6)->dateTimeBetween('-30 days', 'now'),
            'payment_data' => [
                'payment_method' => 'card',
                'last_4' => $this->faker->numerify('####'),
            ],
        ];
    }
}
