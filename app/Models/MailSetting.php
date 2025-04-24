<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MailSetting extends Model
{
    protected $fillable = [
        'mailer',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name'
    ];

    public static function allCached()
    {
        try {
            return Cache::remember('mail_settings', now()->addHours(24), function () {
                $settings = self::first() ?? new self();
                Log::info('Mail settings fetched from database.', ['settings' => $settings->toArray()]);
                return $settings;
            });
        } catch (\Exception $e) {
            Log::error('Failed to fetch mail settings from cache.', ['error' => $e->getMessage()]);
            return new self();
        }
    }

    public static function clearCache()
    {
        try {
            Cache::forget('mail_settings');
            Log::info('Mail settings cache cleared.');
        } catch (\Exception $e) {
            Log::error('Failed to clear mail settings cache.', ['error' => $e->getMessage()]);
        }
    }
}
