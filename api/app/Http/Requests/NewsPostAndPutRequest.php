<?php

namespace App\Http\Requests;

use App\Models\Enums\Books\FileType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsPostAndPutRequest extends FormRequest
{
    use ConvertResponseToJson;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:128'],
            'body' => ['required', 'string', 'max:1024'],
            'categories_id' => [
                'required',
                'exists:App\Models\Category,id'
            ],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Informe o título da notícia.',
            'title.max' => 'O título da notícia deve ter no máximo 128 caracteres.',
            'body.required' => 'Escreva o corpo da notícia, já que elas não possuem somente títulos!',
            'body.max' => 'O corpo da notícia só deve ter no máximo 1024 caracteres.',
            'categories_id.required' => 'Informe a categoria da notícia.',
            'categories_id.exists' => 'Categoria inválida.',
        ];
    }
}
