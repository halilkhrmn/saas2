<?php

namespace Database\Seeders;

use App\Models\SubscriptionPackage;
use Illuminate\Database\Seeder;

class SubscriptionPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Perfect for testing and small projects',
                'monthly_price' => 0.00,
                'yearly_price' => 0.00,
                'api_calls_limit' => 1000,
                'features' => [
                    '1,000 API calls/month',
                    'Basic support',
                    'Standard rate limits'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Great for growing businesses',
                'monthly_price' => 29.00,
                'yearly_price' => 290.00,
                'api_calls_limit' => 100000,
                'features' => [
                    '100,000 API calls/month',
                    'Priority support',
                    'Higher rate limits',
                    'Advanced analytics'
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'For large scale applications',
                'monthly_price' => 99.00,
                'yearly_price' => 990.00,
                'api_calls_limit' => 1000000,
                'features' => [
                    '1,000,000 API calls/month',
                    '24/7 dedicated support',
                    'No rate limits',
                    'Custom integrations'
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($packages as $packageData) {
            SubscriptionPackage::create($packageData);
        }
    }
}
