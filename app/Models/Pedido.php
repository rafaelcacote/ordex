<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_itens',
        'total_pedido',
        'data',
        'hora',
        'status',
        'fornecedor_id',
        'observacao',
        'user_id',
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class);
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
