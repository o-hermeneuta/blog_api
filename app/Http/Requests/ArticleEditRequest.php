<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleEditRequest extends FormRequest
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
            "background" => 'nullable|string',
            "title" => 'nullable|string|unique:articles,title',
            "author" => 'nullable|string',
            "content" => 'nullable|string',
            "in_carrousel" => 'nullable|boolean'
        ];
    }
}
