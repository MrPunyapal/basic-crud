<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // @codeCoverageIgnoreStart
        UploadedFile::macro('makeFromUrl', function (string $url): ?UploadedFile {
            $tempFile = tempnam(sys_get_temp_dir(), Str::random(32));

            if ($tempFile === false) {
                return null;
            }

            $file = file_get_contents($url);

            if ($file === false) {
                return null;
            }

            file_put_contents($tempFile, $file);

            return new UploadedFile(
                $tempFile,
                basename($url),
                mime_content_type($tempFile) ?: null,
                null,
                true
            );
        });
        // @codeCoverageIgnoreEnd
    }
}
