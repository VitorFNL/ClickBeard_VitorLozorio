<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EloquentBarbeiro extends Model
{
    use HasFactory;

    protected $table = 'barbeiros';
    protected $primaryKey = 'barbeiro_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'data_contratacao', 
        'ativo',
        'data_criacao',
        'data_atualizacao',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'data_contratacao' => 'date',
        'ativo' => 'boolean',
        'data_criacao' => 'datetime',
        'data_atualizacao' => 'datetime',
    ];

    public $timestamps = false;

    public function agendamentos(): HasMany
    {
        return $this->hasMany(EloquentAgendamento::class, 'barbeiro_id', 'barbeiro_id');
    }

    public function especialidades(): BelongsToMany
    {
        return $this->belongsToMany(
            EloquentEspecialidade::class,
            'barbeiros_especialidades',
            'barbeiro_id',
            'especialidade_id',
            'barbeiro_id',
            'especialidade_id'
        );
    }
}