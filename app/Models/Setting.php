<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function getSettings()
    {
        return cache()->remember('settings', 3600, function () {
            return self::pluck('value', 'key')->toArray();
        });
    }

    protected static function booted()
    {
        static::saved(function () {
            cache()->forget('settings');
        });

        static::deleted(function () {
            cache()->forget('settings');
        });
    }
}
