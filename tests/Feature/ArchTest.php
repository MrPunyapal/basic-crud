<?php

test('globals')
    ->expect(['dd', 'dump', 'env', 'ray'])
    ->not->toBeUsed();

test('controllers are suffixed with Controller')
    ->expect('App\Http\Controllers')
    ->toHaveSuffix('Controller');

test('models not to be suffixed with Model')
    ->expect('App\Models')
    ->not->toHaveSuffix('Model');
