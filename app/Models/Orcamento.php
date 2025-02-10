<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'prazo',
        'data',
        'status',
        'fornecedor_id',
        'total_itens',
        'total_orcamento',
        'observacao',
    ];

    // Relacionamento com Fornecedor
    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function itensOrcamento()
    {
        return $this->hasMany(ItemOrcamento::class, 'orcamento_id');
    }

    // Função para formatar o valor do orçamento como moeda
    public function getTotalOrcamentoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->total_orcamento, 2, ',', '.');
    }

    public function getPrazoFormatadoAttribute()
    {
        // Verifica se o campo prazo é válido e formata a data
        return date('d/m/Y', strtotime($this->prazo));
    }

    public function getDataFormatadaAttribute()
    {
        // Verifica se o campo data é válido e formata a data
        return date('d/m/Y', strtotime($this->data));
    }
}
