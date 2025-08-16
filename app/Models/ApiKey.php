<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'key',
        'prefix',
        'is_active',
        'usage_count',
        'last_used_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'usage_count' => 'integer',
            'last_used_at' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (ApiKey $apiKey) {
            if (empty($apiKey->key)) {
                $apiKey->key = self::generateApiKey();
            }
            if (empty($apiKey->prefix)) {
                $apiKey->prefix = 'sk_' . Str::random(6);
            }
            if (empty($apiKey->name)) {
                $apiKey->name = 'API Key ' . now()->format('M j, Y');
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function recordUsage(): void
    {
        $this->increment('usage_count');
        $this->update(['last_used_at' => now()]);
    }

    public static function generateApiKey(): string
    {
        return 'sk_' . Str::random(32);
    }

    public function getMaskedKeyAttribute(): string
    {
        if (strlen($this->key) <= 8) {
            return $this->key;
        }

        return substr($this->key, 0, 8) . str_repeat('*', strlen($this->key) - 12) . substr($this->key, -4);
    }

    public static function findByKey(string $key): ?self
    {
        return self::where('key', $key)->where('is_active', true)->first();
    }
}
