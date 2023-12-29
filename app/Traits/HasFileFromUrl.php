<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait HasFileFromUrl
{
    public function resolveFileFromUrl(string $field): void
    {
        if (! $this->hasFile($field) && filter_var($this->get($field), FILTER_VALIDATE_URL)) {

            $file = UploadedFile::makeFromUrl(
                (string) $this->string($field)
            );

            if ($file !== null) {
                $this->merge([
                    $field => $file,
                ]);
            }
        }
    }
}
