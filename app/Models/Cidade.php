<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;

    protected $table = 'cidades';

    protected $fillable = [
        'nome',
        'est_sgl',
        'estados_id',
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estados_id');
    }


    public function fornecedores()
    {
        return $this->hasMany(Fornecedor::class, 'cidades_id');
    }


}
