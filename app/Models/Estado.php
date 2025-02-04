<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estados';

    protected $fillable = [
        'nome',
        'sgl',
    ];

    public function cidades()
    {
        return $this->hasMany(Cidade::class);
    }
}
