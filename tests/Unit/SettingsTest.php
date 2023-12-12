<?php

namespace Tests\Unit;

use App\Support\Settings;

test('has tags', function () {
    $tags = ['Eloquent', 'Blade', 'Migrations', 'Seeding', 'Routing', 'Controllers', 'Middleware', 'Requests', 'Responses', 'Views', 'Forms', 'Validation', 'Mail', 'Notifications'];

    $this->assertSame($tags, Settings::getTags());
});
