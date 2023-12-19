<?php

namespace Tests\Unit;

use App\Support\Settings;

test('has tags', function () {
    expect(Settings::getTags())->toBe(['Eloquent', 'Blade', 'Migrations', 'Seeding', 'Routing', 'Controllers', 'Middleware', 'Requests', 'Responses', 'Views', 'Forms', 'Validation', 'Mail', 'Notifications']);
});

test('has locales', function () {
    expect(Settings::getLocales())->toBe([
        'en' => 'English',
        'fr' => 'French',
        'ar' => 'Arabic',
        'hi' => 'Hindi',
        'gu' => 'Gujarati',
    ]);
});

test('is rtl', function () {
    expect(Settings::isRtl('ar'))->toBeTrue();
    expect(Settings::isRtl('en'))->toBeFalse();
});
