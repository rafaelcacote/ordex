<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['codigo', 'nome', 'tipo', 'medida', 'status', 'estoque', 'categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function getTipoDisplayAttribute()
    {
        return $this->tipo == 'P' ? 'Produto' : ($this->tipo == 'S' ? 'Serviço' : $this->tipo);
    }
}
