<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = true;

    /**
     * Get all settings with caching
     */
    public static function allCached(): array
    {
        return Cache::remember('app_settings', now()->addHours(1), function () {
            return self::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get a specific setting value
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $settings = self::allCached();
        return $settings[$key] ?? $default;
    }

    /**
     * Update or create a setting
     */
    public static function setValue(string $key, mixed $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        self::clearCache();
    }

    /**
     * Clear settings cache
     */
    public static function clearCache(): void
    {
        Cache::forget('app_settings');
    }

    protected static function booted(): void
    {
        static::saved(function () {
            self::clearCache();
        });

        static::deleted(function () {
            self::clearCache();
        });
    }
}
