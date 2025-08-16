<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\SubscriptionPackage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSubscription>
 */
class UserSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startsAt = $this->faker->dateTimeBetween('-6 months', 'now');
        $billingCycle = $this->faker->randomElement(['monthly', 'yearly']);
        $endsAt = clone $startsAt;
        $endsAt->modify($billingCycle === 'monthly' ? '+1 month' : '+1 year');
        
        return [
            'user_id' => User::factory(),
            'subscription_package_id' => SubscriptionPackage::factory(),
            'billing_cycle' => $billingCycle,
            'status' => $this->faker->randomElement(['active', 'cancelled', 'expired', 'pending']),
            'price_paid' => $this->faker->randomFloat(2, 0, 199),
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'cancelled_at' => $this->faker->optional(0.2)->dateTimeBetween($startsAt, 'now'),
            'api_calls_used' => $this->faker->numberBetween(0, 50000),
        ];
    }
}
