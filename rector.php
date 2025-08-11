<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Set\LaravelSetList;

/**
 * Rector Configuration
 *
 * This file configures Rector, an automated refactoring tool for PHP,
 * to run on a Laravel project with PHP 8.3 compatibility and various
 * code quality, modernization, and Laravel-specific improvements.
 */
return RectorConfig::configure()

    /**
     * Define paths Rector should scan and refactor.
     * Includes the Laravel app source, bootstrap file, config, database, and public directories.
     */
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap/app.php',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/public',
    ])

    /**
     * Enable PHP 8.3-specific refactoring rules.
     */
    ->withPhpSets(php83: true)

    /**
     * Explicitly set the target PHP version for Rector to understand
     * what language features can be used.
     */
    ->withPhpVersion(PhpVersion::PHP_83)

    /**
     * Enable pre-configured Rector sets for general code improvement.
     *
     * - deadCode: Removes unused code.
     * - codeQuality: Improves code structure & readability.
     * - codingStyle: Applies consistent coding style rules.
     * - typeDeclarations: Adds type hints where possible.
     * - privatization: Changes properties/methods to private when possible.
     * - instanceOf: Improves instanceof checks.
     * - earlyReturn: Simplifies code by returning early when conditions are met.
     * - strictBooleans: Makes boolean comparisons more explicit and strict.
     * - carbon: Improves Carbon date handling code.
     */
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        instanceOf: true,
        earlyReturn: true,
        strictBooleans: true,
        carbon: true,
    )

    /**
     * Enable Laravel-specific Rector sets for upgrading and improving Laravel code.
     *
     * - LARAVEL_110: Applies changes required for Laravel 11.0 compatibility.
     * - LARAVEL_CODE_QUALITY: Improves Laravel-specific code style and patterns.
     * - LARAVEL_IF_HELPERS: Converts `if` helper usage to standard PHP equivalents.
     * - LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL: Replaces `array_*` and `str_*` helpers with static methods.
     * - LARAVEL_FACADE_ALIASES_TO_FULL_NAMES: Replaces short Facade names with fully qualified class names.
     * - LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER: Converts magic method calls to explicit query builder methods.
     * - LARAVEL_CONTAINER_STRING_TO_FULLY_QUALIFIED_NAME: Converts string-based container bindings to fully qualified class names.
     * - LARAVEL_ARRAYACCESS_TO_METHOD_CALL: Converts ArrayAccess usage in Laravel models/collections to method calls.
     * - LARAVEL_COLLECTION: Improves usage of Laravel's Collection methods.
     */
    ->withSets([
        LaravelSetList::LARAVEL_110,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_IF_HELPERS,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
        LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
        LaravelSetList::LARAVEL_CONTAINER_STRING_TO_FULLY_QUALIFIED_NAME,
        LaravelSetList::LARAVEL_ARRAYACCESS_TO_METHOD_CALL,
        LaravelSetList::LARAVEL_COLLECTION,
    ])

    /**
     * Configure import behavior:
     * - importDocBlockNames: false → Do not automatically import class names in PHPDoc blocks.
     */
    ->withImportNames(importDocBlockNames: false);
