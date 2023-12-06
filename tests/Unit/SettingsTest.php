<?php

namespace Tests\Unit;

use App\Support\Settings;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    public function test_has_categories(): void
    {
        $categories = ['Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React.js', 'Angular.js', 'Java', 'C#'];

        $this->assertSame($categories, Settings::getCategories());
    }

    public function test_has_tags(): void
    {
        $tags = ['Eloquent', 'Blade', 'Migrations', 'Seeding', 'Routing', 'Controllers', 'Middleware', 'Requests', 'Responses', 'Views', 'Forms', 'Validation', 'Mail', 'Notifications'];

        $this->assertSame($tags, Settings::getTags());
    }
}
