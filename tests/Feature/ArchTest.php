<?php

test('globals')
    ->expect(['dd', 'dump', 'env', 'ray'])
    ->not->toBeUsed();
