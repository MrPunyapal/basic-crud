<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Support\Settings;
use Illuminate\Support\Facades\App;

test('has tags', function (): void {
    expect(Settings::getTags())->toBe(['Eloquent', 'Blade', 'Migrations', 'Seeding', 'Routing', 'Controllers', 'Middleware', 'Requests', 'Responses', 'Views', 'Forms', 'Validation', 'Mail', 'Notifications']);
});

test('has locales', function (): void {
    expect(Settings::getLocales())->toBe([
        'en' => 'English',
        'fr' => 'French',
        'ar' => 'Arabic',
        'hi' => 'Hindi',
        'gu' => 'Gujarati',
    ]);
});

test('is rtl', function (): void {
    expect(Settings::isRtl('ar'))->toBeTrue()
        ->and(Settings::isRtl('en'))->toBeFalse();
});

test('get direction for RTL and LTR locale', function ($locale, $dir): void {
    App::shouldReceive('getLocale')
        ->once()
        ->andReturn($locale);
    expect(Settings::getDirection())->toBe($dir);
})->with([
    ['ar', 'rtl'],
    ['en', 'ltr'],
]);
