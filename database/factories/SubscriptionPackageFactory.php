<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubscriptionPackage>
 */
class SubscriptionPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $monthlyPrice = $this->faker->randomFloat(2, 0, 199);
        return [
            'name' => $this->faker->words(2, true),
            'slug' => $this->faker->unique()->slug(2),
            'description' => $this->faker->sentence(),
            'monthly_price' => $monthlyPrice,
            'yearly_price' => $monthlyPrice * 10,
            'api_calls_limit' => $this->faker->randomElement([1000, 10000, 100000, 1000000]),
            'features' => [
                $this->faker->sentence(),
                $this->faker->sentence(),
                $this->faker->sentence(),
            ],
            'is_active' => $this->faker->boolean(90),
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
