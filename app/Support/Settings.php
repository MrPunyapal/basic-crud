<?php

namespace App\Support;

class Settings
{
    private static array $categories = ['Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React.js', 'Angular.js', 'Java', 'C#'];

    private static array $tags = ['Eloquent', 'Blade', 'Migrations', 'Seeding', 'Routing', 'Controllers', 'Middleware', 'Requests', 'Responses', 'Views', 'Forms', 'Validation', 'Mail', 'Notifications'];

    public static function getCategories(): array
    {
        return self::$categories;
    }

    public static function getTags(): array
    {
        return self::$tags;
    }
}
