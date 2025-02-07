<?php

namespace App\Http\Requests\Fornecedores;

use Illuminate\Foundation\Http\FormRequest;

class StoreFornecedorRequest extends FormRequest
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
            'tipo' => 'required|',
            'cpf_cnpj' => 'required|string|max:18',
            'nome' => 'required|string|max:255',
            'ins_estadual' => 'nullable|string|max:20',
            'ins_municipal' => 'nullable|string|max:20',
            'telefone1' => 'required|string|max:15',
            'telefone2' => 'nullable|string|max:15',
            'logradouro' => 'required|string|max:255',
            'numero' => 'nullable|string|max:10',
            'bairro' => 'required|string|max:100',
            'cep' => 'required|string|max:10',
            'cidade_id' => 'required|',
        ];
    }


    public function messages(): array
    {
        return [
            'tipo.required' => 'O campo tipo é obrigatório.',
            'cpf_cnpj.required' => 'O campo CPF/CNPJ é obrigatório.',
            'cpf_cnpj.max' => 'O CPF/CNPJ não pode ter mais de 18 caracteres.',
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.',
            'ins_estadual.max' => 'A inscrição estadual não pode ter mais de 20 caracteres.',
            'ins_municipal.max' => 'A inscrição municipal não pode ter mais de 20 caracteres.',
            'telefone1.required' => 'O campo telefone 1 é obrigatório.',
            'telefone1.max' => 'O telefone 1 não pode ter mais de 15 caracteres.',
            'telefone2.max' => 'O telefone 2 não pode ter mais de 15 caracteres.',
            'logradouro.required' => 'O campo logradouro é obrigatório.',
            'logradouro.max' => 'O logradouro não pode ter mais de 255 caracteres.',
            'numero.max' => 'O número não pode ter mais de 10 caracteres.',
            'bairro.required' => 'O campo bairro é obrigatório.',
            'bairro.max' => 'O bairro não pode ter mais de 100 caracteres.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'cep.max' => 'O CEP não pode ter mais de 10 caracteres.',
            'cidade_id.required' => 'O campo cidade é obrigatório.',

        ];
    }
}
