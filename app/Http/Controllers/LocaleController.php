<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

final class LocaleController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $locale): RedirectResponse
    {
        return back()->withCookie(cookie()->forever('locale', $locale));
    }
}
