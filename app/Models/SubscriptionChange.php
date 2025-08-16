<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionChange extends Model
{
    protected $fillable = [
        'user_id',
        'old_subscription_id',
        'new_subscription_id',
        'change_type',
        'proration_amount',
        'credit_amount',
        'change_details',
        'effective_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'proration_amount' => 'decimal:2',
            'credit_amount' => 'decimal:2',
            'change_details' => 'array',
            'effective_date' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function oldSubscription(): BelongsTo
    {
        return $this->belongsTo(UserSubscription::class, 'old_subscription_id');
    }

    public function newSubscription(): BelongsTo
    {
        return $this->belongsTo(UserSubscription::class, 'new_subscription_id');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function isUpgrade(): bool
    {
        return $this->change_type === 'upgrade';
    }

    public function isDowngrade(): bool
    {
        return $this->change_type === 'downgrade';
    }
}
