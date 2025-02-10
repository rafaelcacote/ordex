<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasPagar extends Model
{
    use HasFactory;

    protected $table = 'contas_pagar';

    protected $fillable = [
        'data',
        'parcela',
        'multa',
        'juros',
        'vencimento',
        'status',
        'data_quitacao',
        'valor_quitacao',
        'descricao',
        'documento',
        'observacao',
        'pedido_id',
        'forma_pagamento_id',
    ];

    // Relacionamento com Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // Relacionamento com FormaPagamento
    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class);
    }

    // Função para formatar o valor do orçamento como moeda
    public function getValorQuitacaoAttribute()
    {
        return 'R$ ' . number_format($this->attributes['valor_quitacao'], 2, ',', '.');
    }

    public function getVencimentoAttribute()
    {

        return date('d/m/Y', strtotime($this->attributes['vencimento']));
    }

    public function getDataFormatadaAttribute()
    {
        // Verifica se o campo data é válido e formata a data
        return date('d/m/Y', strtotime($this->data));
    }
}
