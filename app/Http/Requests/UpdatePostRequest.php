<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
        $rules = (new StorePostRequest())->rules();

        return [
            ...$rules,
            'slug' => [
                'required',
                'max:120',
                $this->route('post') instanceof \App\Models\Post ? 'unique:posts,slug,'.$this->route('post')->id : 'unique:posts,slug',
                'alpha_dash:ascii',
            ],
            'image' => ['nullable', 'image'],
        ];
    }
}
