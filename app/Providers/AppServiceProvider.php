<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;

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

        // Register the Blade directive
        Blade::directive('cleanExcerpt', function ($expression) {
            // Parse the expression to get content and optional length
            $parts = explode(',', $expression);
            $content = trim($parts[0]);
            $length = isset($parts[1]) ? trim($parts[1]) : 150;

            return "<?php
                \$content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                \$content = strip_tags(\$content);
                \$content = str_replace(['&nbsp;', '&ndash;', '&mdash;'], [' ', '–', '—'], \$content);
                \$content = preg_replace('/\s+/', ' ', \$content);
                echo Str::limit(trim(\$content), $length);
            ?>";
        });

        // Register a global helper function
        Str::macro('cleanExcerpt', function ($content, $length = 150) {
            $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $content = strip_tags($content);
            $content = str_replace(['&nbsp;', '&ndash;', '&mdash;'], [' ', '–', '—'], $content);
            $content = preg_replace('/\s+/', ' ', $content);
            return Str::limit(trim($content), $length);
        });
    }
}
