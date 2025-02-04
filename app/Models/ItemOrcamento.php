<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOrcamento extends Model
{
    use HasFactory;

    // Nome da tabela no banco de dados
    protected $table = 'itens_orcamento';

    // Campos que podem ser preenchidos em massa (mass assignment)
    protected $fillable = [
        'quantidade',
        'observacao',
        'orcamento_id',
        'produto_id',
        'valor_unitario',
        'valor_total',
    ];

    // Campos que devem ser tratados como datas
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Relacionamento com o modelo Orcamento
    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class, 'orcamento_id');
    }

    // Relacionamento com o modelo Produto
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
