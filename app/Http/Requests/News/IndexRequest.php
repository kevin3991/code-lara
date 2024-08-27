<?php

namespace App\Http\Requests\News;

use App\Http\Requests\BaseRequest;

class IndexRequest extends BaseRequest
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
     * @return array<string, array<mixed>|\Illuminate\Contracts\Validation\ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'keyword' => 'string',
            'page' => 'integer',
            'per_page' => 'integer',
        ];
    }
}
