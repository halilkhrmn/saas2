<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApiKey>
 */
class ApiKeyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prefix = 'ak_' . Str::random(8);
        $key = $prefix . '_' . Str::random(32);
        
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->words(2, true) . ' API Key',
            'key' => $key,
            'prefix' => $prefix,
            'is_active' => $this->faker->boolean(85),
            'usage_count' => $this->faker->numberBetween(0, 10000),
            'last_used_at' => $this->faker->optional(0.7)->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
