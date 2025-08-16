<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_package_id',
        'billing_cycle',
        'status',
        'price_paid',
        'starts_at',
        'ends_at',
        'cancelled_at',
        'api_calls_used',
    ];

    protected function casts(): array
    {
        return [
            'price_paid' => 'decimal:2',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'api_calls_used' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPackage(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPackage::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('ends_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('ends_at', '<=', now());
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->ends_at > now();
    }

    public function isExpired(): bool
    {
        return $this->ends_at <= now();
    }

    public function getRemainingApiCallsAttribute(): int
    {
        $limit = $this->subscriptionPackage->api_calls_limit ?? 0;
        return max(0, $limit - $this->api_calls_used);
    }

    public function canMakeApiCall(): bool
    {
        if (!$this->isActive()) {
            return false;
        }

        $limit = $this->subscriptionPackage->api_calls_limit;
        return $limit === null || $this->api_calls_used < $limit;
    }
}
