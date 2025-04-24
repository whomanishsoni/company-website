<?php

namespace App\Providers;

use App\Models\MailSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Load mail settings from database
        try {
            $settings = MailSetting::first();
            if ($settings) {
                Config::set('mail.mailer', $settings->mailer);
                Config::set('mail.mailers.smtp.host', $settings->host);
                Config::set('mail.mailers.smtp.port', $settings->port);
                Config::set('mail.mailers.smtp.username', $settings->username);
                Config::set('mail.mailers.smtp.password', $settings->password);
                Config::set('mail.mailers.smtp.encryption', $settings->encryption);
                Config::set('mail.from.address', $settings->from_address);
                Config::set('mail.from.name', $settings->from_name);

                Log::info('Mail settings loaded from database', [
                    'mailer' => $settings->mailer,
                    'host' => $settings->host,
                    'port' => $settings->port,
                    'username' => $settings->username,
                    'encryption' => $settings->encryption,
                    'from_address' => $settings->from_address,
                    'from_name' => $settings->from_name,
                ]);
            } else {
                Log::warning('No mail settings found in database, falling back to .env');
            }
        } catch (\Exception $e) {
            Log::error('Failed to load mail settings from database', [
                'error' => $e->getMessage(),
            ]);
        }

        // Register the Blade directive
        Blade::directive('cleanExcerpt', function ($expression) {
            // Parse the expression to get content and optional length
            $parts = explode(',', $expression);
            $content = trim($parts[0]);
            $length = isset($parts[1]) ? trim($parts[1]) : 150;

            return "<?php
                \$content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                \$content = strip_tags(\$content);
                \$content = str_replace([' ', '–', '—'], [' ', '–', '—'], \$content);
                \$content = preg_replace('/\s+/', ' ', \$content);
                echo Str::limit(trim(\$content), $length);
            ?>";
        });

        // Register a global helper function
        Str::macro('cleanExcerpt', function ($content, $length = 150) {
            $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $content = strip_tags($content);
            $content = str_replace([' ', '–', '—'], [' ', '–', '—'], $content);
            $content = preg_replace('/\s+/', ' ', $content);
            return Str::limit(trim($content), $length);
        });
    }
}
