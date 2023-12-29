<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:100'],
            'slug' => ['required', 'max:120', 'unique:posts', 'alpha_dash:ascii'],
            'description' => ['required'],
            'image' => ['required', 'image'],
            'content' => ['required'],
            'published_at' => ['nullable', 'date'],
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'tags' => ['nullable', 'array', 'max:3'],
            'tags.*' => ['string', 'max:20'],
            'is_featured' => ['boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (! $this->hasFile('image') && filter_var($this->get('image'), FILTER_VALIDATE_URL)) {

            $file = UploadedFile::makeFromUrl(
                (string) $this->string('image')
            );

            if ($file === null) {
                return;
            }

            $this->merge([
                'image' => $file,
            ]);
        }
    }
}
