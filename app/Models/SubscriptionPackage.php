<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPackage extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'monthly_price',
        'yearly_price',
        'api_calls_limit',
        'features',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'monthly_price' => 'decimal:2',
            'yearly_price' => 'decimal:2',
            'features' => 'array',
            'is_active' => 'boolean',
            'api_calls_limit' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function userSubscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function getMonthlyPriceFormattedAttribute(): string
    {
        return '$' . number_format($this->monthly_price, 2);
    }

    public function getYearlyPriceFormattedAttribute(): string
    {
        return '$' . number_format($this->yearly_price, 2);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function canUpgradeFrom($currentPackage): bool
    {
        if (!$currentPackage) {
            return true;
        }

        // Sort order'a göre upgrade kontrolü (düşük sort_order = yüksek tier)
        if ($this->sort_order === $currentPackage->sort_order) {
            return $this->monthly_price > $currentPackage->monthly_price;
        }
        
        return $this->sort_order < $currentPackage->sort_order;
    }

    public function isCurrentPackage($currentPackage): bool
    {
        return $currentPackage && $this->id === $currentPackage->id;
    }
}
