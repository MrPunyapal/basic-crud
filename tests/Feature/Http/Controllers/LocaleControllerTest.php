<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

test('can set locale', function ($locale): void {
    $this->from(route('posts.index'))
        ->get(route('set-locale', $locale))
        ->assertStatus(302)
        ->assertRedirect(route('posts.index'))
        ->assertCookie('locale', $locale);
})->with(['en', 'fr']);

test('can set locale from cookie', function ($locale): void {
    $this->from(route('posts.index'))
        ->withCookie('locale', $locale)
        ->get(route('posts.index'))
        ->assertStatus(200);

    expect(app()->getLocale())->toBe($locale);
})->with(['hi', 'gu']);
