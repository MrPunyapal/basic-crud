<?php

namespace App\Support;

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

    public static function getTags(): array
    {
        return self::TAGS;
    }

    public static function getLocales(): array
    {
        return self::LOCALES;
    }

    public static function isRtl(string $locale): bool
    {
        return in_array($locale, ['ar']);
    }
}
