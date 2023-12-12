<?php

namespace App\Support;

final class Settings
{
    private const CATEGORIES = ['Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React.js', 'Angular.js', 'Java', 'C#'];

    private const TAGS = ['Eloquent', 'Blade', 'Migrations', 'Seeding', 'Routing', 'Controllers', 'Middleware', 'Requests', 'Responses', 'Views', 'Forms', 'Validation', 'Mail', 'Notifications'];

    public static function getCategories(): array
    {
        return self::CATEGORIES;
    }

    public static function getTags(): array
    {
        return self::TAGS;
    }
}
