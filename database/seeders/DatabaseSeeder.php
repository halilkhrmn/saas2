<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SubscriptionPackage;
use App\Models\UserSubscription;
use App\Models\ApiKey;
use App\Models\Invoice;
use App\Models\PaymentMethod;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First, seed subscription packages
        $this->call(SubscriptionPackageSeeder::class);
        
        // Create Filament admin user
        $adminUser = User::factory()->create([
            'name' => 'Filament Admin',
            'email' => 'admin@admin.com',
            'password' => '141535',
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);
        
        // Create test user  
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
        ]);
        
        // Create additional demo users
        $users = User::factory(8)->create();
        $allUsers = collect([$adminUser, $testUser])->merge($users);
        
        // Get the created packages
        $packages = SubscriptionPackage::all();
        
        // Create subscriptions for users
        foreach ($allUsers as $user) {
            // 80% chance to have an active subscription
            if (fake()->boolean(80)) {
                $subscription = UserSubscription::factory()->create([
                    'user_id' => $user->id,
                    'subscription_package_id' => $packages->random()->id,
                    'status' => fake()->randomElement(['active', 'active', 'active', 'cancelled', 'expired']),
                ]);
                
                // Create payment methods for users with subscriptions
                PaymentMethod::factory(fake()->numberBetween(1, 3))->create([
                    'user_id' => $user->id,
                ]);
                
                // Create invoices for this subscription
                Invoice::factory(fake()->numberBetween(1, 5))->create([
                    'user_id' => $user->id,
                    'user_subscription_id' => $subscription->id,
                ]);
            }
            
            // Create API keys for users
            ApiKey::factory(fake()->numberBetween(1, 4))->create([
                'user_id' => $user->id,
            ]);
        }
        
        // Create some additional invoices and API keys
        Invoice::factory(20)->create();
        ApiKey::factory(15)->create();
    }
}
