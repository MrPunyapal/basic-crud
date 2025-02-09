<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FileUploaderFromUrl
{
    public function __invoke(string $url): ?UploadedFile
    {
        $response = Http::get($url);

        if ($response->failed()) {
            return null;
        }

        $tempFile = $this->tempnam(sys_get_temp_dir(), Str::random(32));

        if ($tempFile === false) {
            return null;
        }

        file_put_contents($tempFile, $response->body());

        return new UploadedFile(
            $tempFile,
            basename($url),
            $response->header('Content-Type') ?: null,
            null,
            true
        );
    }

    public function tempnam(string $dir, string $prefix): string|false
    {
        return tempnam($dir, $prefix);
    }
}
