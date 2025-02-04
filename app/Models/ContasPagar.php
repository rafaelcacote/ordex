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
}
