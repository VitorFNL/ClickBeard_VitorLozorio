<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BarbeirosEspecialidade extends Pivot
{
    protected $table = 'barbeiros_especialidades';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $fillable = [
        'barbeiro_id',
        'especialidade_id',
        'data_criacao'
    ];
    protected $casts = ['data_criacao' => 'datetime'];
    public $timestamps = false;
}