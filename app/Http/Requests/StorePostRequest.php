<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Traits\HasFileFromUrl;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StorePostRequest extends FormRequest
{
    use HasFileFromUrl;

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
     * @return array<string, (ValidationRule | array<mixed> | string)>
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
    #[Override]
    protected function prepareForValidation(): void
    {
        $this->resolveFileFromUrl('image');
    }
}
