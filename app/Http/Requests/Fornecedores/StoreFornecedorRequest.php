<?php

namespace App\Http\Requests\Fornecedores;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'tipo' => 'required|in:F,J', // Garante que o tipo seja "F" (CPF) ou "J" (CNPJ)
            'cpf_cnpj' => [
                'required',
                'string',
                'max:18',
                function ($attribute, $value, $fail) {
                    // Remove caracteres não numéricos
                    $value = preg_replace('/[^0-9]/', '', $value);

                    // Verifica o tipo (F para CPF, J para CNPJ)
                    if ($this->input('tipo') === 'F' && !$this->validarCpf($value)) {
                        $fail('O CPF informado é inválido.');
                    } elseif ($this->input('tipo') === 'J' && !$this->validarCnpj($value)) {
                        $fail('O CNPJ informado é inválido.');
                    }
                },
            ],
            'nome' => 'required|string|max:255',
            'ins_estadual' => 'nullable|string|max:20',
            'ins_municipal' => 'nullable|string|max:20',
            'telefone1' => 'required|string|max:15',
            'telefone2' => 'nullable|string|max:15',
            'logradouro' => 'required|string|max:255',
            'numero' => 'nullable|string|max:5',
            'bairro' => 'required|string|max:100',
            'cep' => 'required|string|max:10',
            'cidade_id' => 'required|exists:cidades,id', // Garante que o cidade_id exista na tabela cidades
        ];
    }

    /**
     * Valida CPF.
     *
     * @param string $cpf
     * @return bool
     */
    private function validarCpf($cpf)
    {
        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais (ex: 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Validação do CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * Valida CNPJ.
     *
     * @param string $cnpj
     * @return bool
     */
    private function validarCnpj($cnpj)
    {
        // Remove qualquer caractere não numérico
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Verifica se o CNPJ tem 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se todos os dígitos são iguais (ex: 11.111.111/1111-11)
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Cálculo do primeiro dígito verificador
        $soma = 0;
        $peso = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];  // Pesos para o cálculo
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $peso[$i];
        }
        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;

        // Cálculo do segundo dígito verificador
        $soma = 0;
        $peso = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];  // Pesos para o cálculo
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $peso[$i];
        }
        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;

        // Verifica se os dígitos calculados são iguais aos informados
        if ($cnpj[12] != $digito1 || $cnpj[13] != $digito2) {
            return false;
        }

        return true;
    }


    public function messages(): array
    {
        return [
            'tipo.required' => 'O campo tipo é obrigatório.',
            'tipo.in' => 'O tipo deve ser "Pessoa Física" (F) ou "Pessoa Jurídica" (J).',
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
            'numero.max' => 'O número não pode ter mais de 5 caracteres.',
            'bairro.required' => 'O campo bairro é obrigatório.',
            'bairro.max' => 'O bairro não pode ter mais de 100 caracteres.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'cep.max' => 'O CEP não pode ter mais de 10 caracteres.',
            'cidade_id.required' => 'O campo cidade é obrigatório.',
            'cidade_id.exists' => 'A cidade selecionada é inválida.',
        ];
    }
}
