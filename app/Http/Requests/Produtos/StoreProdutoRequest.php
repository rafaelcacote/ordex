<?php

namespace App\Http\Requests\Produtos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }



    public function rules()
    {
        return [
            'codigo' => [
                'required',
                'string',
                'max:20',
                Rule::unique('produtos'), // Verifica se o código é único na tabela `produtos`
            ],
            'nome' => [
                'required',
                'string',
                'max:60',
                Rule::unique('produtos'), // Verifica se o nome é único na tabela `produtos`
            ],
            'tipo' => 'required',
            'categoria_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'codigo.required' => 'O campo código é obrigatório.',
            'codigo.max' => 'O campo código não pode ter mais de 20 caracteres.',
            'codigo.unique' => 'Este código já está em uso.',

            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O campo nome não pode ter mais de 60 caracteres.',
            'nome.unique' => 'Este nome já está em uso.',

            'tipo.required' => 'O campo tipo é obrigatório.',

            'categoria_id.required' => 'O campo categoria é obrigatório.',
        ];
    }
}
