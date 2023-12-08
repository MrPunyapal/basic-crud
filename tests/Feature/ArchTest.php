<?php

test('globals')
    ->expect(['dd', 'dump', 'env', 'ray'])
    ->not->toBeUsed();

test('controllers are suffixed with Controller')
    ->expect('App\Http\Controllers')
    ->toHaveSuffix('Controller');

test('Requests are suffixed with Request')
    ->expect('App\Http\Requests')
    ->toHaveSuffix('Request');

test('models not to be suffixed with Model')
    ->expect('App\Models')
    ->not->toHaveSuffix('Model');
