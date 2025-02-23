<?php

declare(strict_types=1);

namespace App\Providers;

use App\Support\FileUploaderFromUrl;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\ServiceProvider;
use Override;

final class AppServiceProvider extends ServiceProvider
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
        UploadedFile::macro('makeFromUrl', fn (string $url): ?UploadedFile => (new FileUploaderFromUrl)($url));
    }
}
