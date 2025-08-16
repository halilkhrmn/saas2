<?php

namespace App\Services;

use App\Models\PaymentMethod;
use App\Models\SubscriptionChange;
use App\Models\SubscriptionPackage;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\DB;

class SubscriptionChangeService
{
    public function changeSubscription(
        User $user,
        SubscriptionPackage $newPackage,
        string $billingCycle = 'monthly',
        bool $immediate = false
    ): SubscriptionChange {
        return DB::transaction(function () use ($user, $newPackage, $billingCycle, $immediate) {
            $currentSubscription = $user->activeSubscription;

            if (!$currentSubscription) {
                throw new \Exception('User has no active subscription');
            }

            $changeType = $this->determineChangeType($currentSubscription->subscriptionPackage, $newPackage);
            $prorationData = $this->calculateProration($currentSubscription, $newPackage, $billingCycle);

            $newSubscription = $this->createNewSubscription($user, $newPackage, $billingCycle, $prorationData);
            
            $subscriptionChange = SubscriptionChange::create([
                'user_id' => $user->id,
                'old_subscription_id' => $currentSubscription->id,
                'new_subscription_id' => $newSubscription->id,
                'change_type' => $changeType,
                'proration_amount' => $prorationData['proration_amount'],
                'credit_amount' => $prorationData['credit_amount'],
                'change_details' => [
                    'old_package' => $currentSubscription->subscriptionPackage->name,
                    'new_package' => $newPackage->name,
                    'old_billing_cycle' => $currentSubscription->billing_cycle,
                    'new_billing_cycle' => $billingCycle,
                ],
                'effective_date' => $immediate ? now() : $currentSubscription->ends_at,
                'status' => 'pending',
            ]);

            if ($immediate) {
                $this->processImmediateChange($subscriptionChange);
            }

            return $subscriptionChange;
        });
    }

    public function processPayment(SubscriptionChange $subscriptionChange): bool
    {
        return DB::transaction(function () use ($subscriptionChange) {
            $user = $subscriptionChange->user;
            $paymentMethods = $user->paymentMethods()->active()->byPriority()->get();

            foreach ($paymentMethods as $paymentMethod) {
                try {
                    $success = $this->attemptPayment($subscriptionChange, $paymentMethod);
                    if ($success) {
                        $subscriptionChange->update(['status' => 'completed']);
                        $this->activateNewSubscription($subscriptionChange);
                        return true;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            $subscriptionChange->update(['status' => 'failed']);
            return false;
        });
    }

    protected function determineChangeType(SubscriptionPackage $oldPackage, SubscriptionPackage $newPackage): string
    {
        if ($oldPackage->monthly_price < $newPackage->monthly_price) {
            return 'upgrade';
        }
        
        if ($oldPackage->monthly_price > $newPackage->monthly_price) {
            return 'downgrade';
        }

        return 'change_billing_cycle';
    }

    protected function calculateProration(UserSubscription $currentSubscription, SubscriptionPackage $newPackage, string $billingCycle): array
    {
        $currentPrice = $currentSubscription->price_paid;
        $newPrice = $billingCycle === 'yearly' ? $newPackage->yearly_price : $newPackage->monthly_price;
        
        $remainingDays = now()->diffInDays($currentSubscription->ends_at, false);
        $totalDays = $currentSubscription->starts_at->diffInDays($currentSubscription->ends_at);
        
        $unusedCredit = ($currentPrice / $totalDays) * max(0, $remainingDays);
        $prorationAmount = max(0, $newPrice - $unusedCredit);

        return [
            'proration_amount' => $prorationAmount,
            'credit_amount' => $unusedCredit,
            'remaining_days' => $remainingDays,
            'new_price' => $newPrice,
        ];
    }

    protected function createNewSubscription(User $user, SubscriptionPackage $package, string $billingCycle, array $prorationData): UserSubscription
    {
        $price = $billingCycle === 'yearly' ? $package->yearly_price : $package->monthly_price;
        $startsAt = now();
        $endsAt = $billingCycle === 'yearly' ? $startsAt->copy()->addYear() : $startsAt->copy()->addMonth();

        return UserSubscription::create([
            'user_id' => $user->id,
            'subscription_package_id' => $package->id,
            'billing_cycle' => $billingCycle,
            'status' => 'pending',
            'price_paid' => $price,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'api_calls_used' => 0,
        ]);
    }

    protected function processImmediateChange(SubscriptionChange $subscriptionChange): void
    {
        $oldSubscription = $subscriptionChange->oldSubscription;
        
        if ($oldSubscription) {
            $oldSubscription->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'ends_at' => now(),
            ]);
        }
        
        $this->processPayment($subscriptionChange);
    }

    protected function attemptPayment(SubscriptionChange $subscriptionChange, PaymentMethod $paymentMethod): bool
    {
        $paymentMethod->markAsUsed();
        
        return true;
    }

    protected function activateNewSubscription(SubscriptionChange $subscriptionChange): void
    {
        $newSubscription = $subscriptionChange->newSubscription;
        $newSubscription->update(['status' => 'active']);

        if ($oldSubscription = $subscriptionChange->oldSubscription) {
            $oldSubscription->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);
        }
    }
}