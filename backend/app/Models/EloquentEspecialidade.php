<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importar HasMany
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Importar BelongsToMany

class EloquentEspecialidade extends Model
{
    use HasFactory;

    protected $table = 'especialidades';
    protected $primaryKey = 'especialidade_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'descricao',
        'data_criacao',
        'data_atualizacao',
    ];

    protected $casts = [
        'data_criacao' => 'datetime',
        'data_atualizacao' => 'datetime',
    ];

    public $timestamps = false;


    public function agendamentos(): HasMany
    {
        return $this->hasMany(EloquentAgendamento::class, 'especialidade_id', 'especialidade_id');
    }

    public function barbeiros(): BelongsToMany
    {
        return $this->belongsToMany(
            EloquentBarbeiro::class,
            'barbeiros_especialidades',
            'especialidade_id',
            'barbeiro_id',
            'especialidade_id',
            'barbeiro_id'
        );
    }
}