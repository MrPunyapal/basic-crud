<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\UploadedFile;

/**
 * @mixin \Illuminate\Foundation\Http\FormRequest
 */
trait HasFileFromUrl
{
    public function resolveFileFromUrl(string $field): void
    {
        if (! $this->hasFile($field) && filter_var($this->get($field), FILTER_VALIDATE_URL)) {
            /**
             * @see \App\Support\FileUploaderFromUrl::__invoke()
             */
            $file = UploadedFile::makeFromUrl(
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
