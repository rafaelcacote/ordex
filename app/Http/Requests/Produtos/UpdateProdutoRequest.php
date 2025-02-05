<?php

namespace App\Http\Requests\Produtos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProdutoRequest extends FormRequest
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
        $produtoId = $this->route('produto');
        return [
            'codigo' => [
                'required',
                'string',
                'max:20',

            ],
            'nome' => [
                'required',
                'string',
                'max:60',

            ],
            'tipo' => 'required',
            'categoria_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'O campo código é obrigatório.',
            'codigo.string' => 'O campo código deve ser uma string.',
            'codigo.max' => 'O campo código não pode ter mais de 20 caracteres.',


            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O campo nome não pode ter mais de 60 caracteres.',

            'tipo.required' => 'O campo tipo é obrigatório.',
            'categoria_id.required' => 'O campo categoria é obrigatório.',
        ];
    }
}
