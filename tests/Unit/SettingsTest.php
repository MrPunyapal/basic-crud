<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Support\Settings;
use Illuminate\Support\Facades\App;

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

test('get direction for RTL and LTR locale', function ($locale, $dir) {
    App::shouldReceive('getLocale')
        ->once()
        ->andReturn($locale);
    expect(Settings::getDir())->toBe($dir);
})->with([
    ['ar', 'rtl'],
    ['en', 'ltr'],
]);
