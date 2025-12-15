<?php

declare(strict_types=1);

namespace App\Traits;

use App\Support\FileUploaderFromUrl;
use Illuminate\Http\UploadedFile;

/**
 * @mixin \Illuminate\Foundation\Http\FormRequest
 */
trait HasFileFromUrl
{
    public function resolveFileFromUrl(string $field): void
    {
        if (! $this->hasFile($field) && filter_var($this->get($field), FILTER_VALIDATE_URL)) {
            $file = resolve(FileUploaderFromUrl::class)(
                (string) $this->string($field)
            );

            if ($file instanceof UploadedFile) {
                $this->merge([
                    $field => $file,
                ]);
            }
        }
    }
}
