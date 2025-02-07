<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;
    protected $table = 'fornecedores';

    protected $fillable = [
        'tipo',
        'cpf_cnpj',
        'nome',
        'ins_estadual',
        'ins_municipal',
        'fantasia',
        'telefone1',
        'telefone2',
        'contato',
        'logradouro',
        'numero',
        'bairro',
        'cep',
        'cidade_id',
        'status'
    ];

    // Validação de CPF ou CNPJ
    public static function validateCpfCnpj($cpf_cnpj)
    {
        if (strlen($cpf_cnpj) == 11) {
            return 'cpf'; // CPF
        } elseif (strlen($cpf_cnpj) == 14) {
            return 'cnpj'; // CNPJ
        }

        return false; // Se não for CPF nem CNPJ
    }

    public function setCpfCnpjAttribute($value)
    {
        // Remove caracteres não numéricos
        $this->attributes['cpf_cnpj'] = preg_replace('/\D/', '', $value);
    }

    // Accessor para o campo cpf_cnpj

    public function getCpfCnpjAttribute($value)
    {
        // Verifica se é CPF ou CNPJ e formata de acordo
        if (strlen($value) === 11) {
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $value);  // CPF
        } elseif (strlen($value) === 14) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $value);  // CNPJ
        }

        return $value;
    }

    private function formatarCPF($cpf)
    {
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }

    private function formatarCNPJ($cnpj)
    {
        return substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
    }


    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function estado()
    {
        return $this->cidade ? $this->cidade->estado : null;
    }

    // Accessor para o campo telefone1
    public function getTelefone1Attribute($value)
    {
        return $this->formatarTelefone($value);
    }

    // Accessor para o campo telefone2 (opcional)
    public function getTelefone2Attribute($value)
    {
        return $this->formatarTelefone($value);
    }

    // Função para formatar o telefone
    private function formatarTelefone($telefone)
    {
        // Remove tudo que não é número
        $telefone = preg_replace('/\D/', '', $telefone);

        // Formata o telefone
        if (strlen($telefone) === 11) { // Telefone com DDD e 9 dígitos
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
        } elseif (strlen($telefone) === 10) { // Telefone com DDD e 8 dígitos
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
        }

        // Retorna o valor original se não for possível formatar
        return $telefone;
    }
}
