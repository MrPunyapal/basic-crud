<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
}
