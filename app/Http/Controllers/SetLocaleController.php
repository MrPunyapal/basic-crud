<?php

namespace App\Http\Controllers;

class SetLocaleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($locale)
    {
        return back()->withCookie(cookie()->forever('locale', $locale));
    }
}
