<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use function Pest\Laravel\from;

test('can set locale', function ($locale) {
    from(route('posts.index'))
        ->get(route('set-locale', $locale))
        ->assertStatus(302)
        ->assertRedirect(route('posts.index'))
        ->assertCookie('locale', $locale);
})->with(['en', 'fr']);
