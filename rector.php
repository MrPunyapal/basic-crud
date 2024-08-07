<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        // __DIR__.'/bootstrap',
        // __DIR__.'/config',
        // __DIR__.'/public',
        // __DIR__.'/resources',
        // __DIR__.'/routes',
        // __DIR__.'/tests',
    ])
    // register single rule
    ->withRules([
        TypedPropertyFromStrictConstructorRector::class,
    ])
    // here we can define, what prepared sets of rules will be applied
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
    )->withSets([
        LaravelSetList::LARAVEL_110,
    ])->withImportNames();
