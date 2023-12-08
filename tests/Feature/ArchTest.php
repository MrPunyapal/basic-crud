<?php

test('globals')
    ->expect(['dd', 'dump', 'env', 'ray'])
    ->not->toBeUsed();

test('controllers are suffixed with Controller')
    ->expect('App\Http\Controllers')
    ->toHaveSuffix('Controller');
