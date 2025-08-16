<?php

namespace App\Models;

use App\PaymentMethodType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentMethodFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'name',
        'provider',
        'provider_payment_method_id',
        'metadata',
        'priority',
        'is_enabled',
        'is_default',
        'verified_at',
        'last_used_at',
    ];

    protected function casts(): array
    {
        return [
            'type' => PaymentMethodType::class,
            'metadata' => 'array',
            'is_enabled' => 'boolean',
            'is_default' => 'boolean',
            'verified_at' => 'datetime',
            'last_used_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsUsed(): void
    {
        $this->update(['last_used_at' => now()]);
    }

    public function isActive(): bool
    {
        return $this->is_enabled && $this->verified_at !== null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_enabled', true)->whereNotNull('verified_at');
    }

    public function scopeByPriority($query)
    {
        return $query->orderBy('priority', 'desc');
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
