<?php

namespace App\Support;

final class Settings
{
    private const TAGS = ['Eloquent', 'Blade', 'Migrations', 'Seeding', 'Routing', 'Controllers', 'Middleware', 'Requests', 'Responses', 'Views', 'Forms', 'Validation', 'Mail', 'Notifications'];

    public static function getTags(): array
    {
        return self::TAGS;
    }
}
