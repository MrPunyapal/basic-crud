<?php

namespace App\Support;

class Settings {
    private static $categories = ['Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React.js', 'Angular.js','Java','C#'];

    private static $tags = ['Eloquent', 'Blade', 'Migrations', 'Seeding', 'Routing', 'Controllers', 'Middleware', 'Requests', 'Responses', 'Views', 'Forms', 'Validation', 'Mail', 'Notifications'];

    public static function getCategories() {
        return self::$categories;
    }

    public static function getTags() {
        return self::$tags;
    }
}
