<?php

declare(strict_types=1);

arch('globals')
    ->expect(['dd', 'dump', 'env', 'ray'])
    ->not->toBeUsed();

arch('request function not to be used in controllers')
    ->expect('request')
    ->not->toBeUsedIn('App\Http\Controllers');

arch('controllers are suffixed with Controller')
    ->expect('App\Http\Controllers')
    ->toHaveSuffix('Controller');

arch('Requests are suffixed with Request')
    ->expect('App\Http\Requests')
    ->toHaveSuffix('Request');

arch('models not to be suffixed with Model')
    ->expect('App\Models')
    ->not->toHaveSuffix('Model');
