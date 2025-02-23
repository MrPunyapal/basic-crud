<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
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

        $tempFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.Str::uuid()->toString();

        File::put($tempFile, $response->body());

        return new UploadedFile(
            $tempFile,
            File::basename($url),
            $response->header('Content-Type') ?: null,
            null,
            true
        );
    }
}
