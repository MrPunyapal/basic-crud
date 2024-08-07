<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\App;

final class Settings
{
    private const TAGS = ['Eloquent', 'Blade', 'Migrations', 'Seeding', 'Routing', 'Controllers', 'Middleware', 'Requests', 'Responses', 'Views', 'Forms', 'Validation', 'Mail', 'Notifications'];

    private const LOCALES = [
        'en' => 'English',
        'fr' => 'French',
        'ar' => 'Arabic',
        'hi' => 'Hindi',
        'gu' => 'Gujarati',
    ];

    /**
     * @return array<int, string>
     */
    public static function getTags(): array
    {
        return self::TAGS;
    }

    /**
     * @return array<string, string>
     */
    public static function getLocales(): array
    {
        return self::LOCALES;
    }

    public static function getDirection(): string
    {
        return self::isRtl(App::getLocale()) ? 'rtl' : 'ltr';
    }

    public static function isRtl(string $locale): bool
    {
        return $locale === 'ar';
    }
}
