<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Traits\HasFileFromUrl;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
        $rules = (new StorePostRequest)->rules();

        return [
            ...$rules,
            'slug' => [
                'required',
                'max:120',
                $this->route('post') instanceof Post ? 'unique:posts,slug,'.$this->route('post')->id : 'unique:posts,slug',
                'alpha_dash:ascii',
            ],
            'image' => ['nullable', 'image'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->resolveFileFromUrl('image');
    }
}
