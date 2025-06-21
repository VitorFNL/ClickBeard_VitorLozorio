<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importar BelongsTo

class EloquentAgendamento extends Model
{
    use HasFactory;

    protected $table = 'agendamentos';
    protected $primaryKey = 'agendamento_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'usuario_id',
        'barbeiro_id',
        'especialidade_id',
        'data_agendamento',
        'hora_inicio',
        'hora_fim',
        'status_agendamento',
        'data_criacao',
        'data_atualizacao',
    ];

    protected $casts = [
        'data_agendamento' => 'date',
        'hora_inicio' => 'time',
        'hora_fim' => 'time',
        'data_criacao' => 'datetime',
        'data_atualizacao' => 'datetime',
    ];

    public $timestamps = false;

    // Relacionamento: Um agendamento pertence a um usuário (cliente)
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(EloquentUsuario::class, 'usuario_id', 'usuario_id');
    }

    // Relacionamento: Um agendamento pertence a um barbeiro
    public function barbeiro(): BelongsTo
    {
        return $this->belongsTo(EloquentBarbeiro::class, 'barbeiro_id', 'barbeiro_id');
    }

    // Relacionamento: Um agendamento pertence a uma especialidade
    public function especialidade(): BelongsTo
    {
        return $this->belongsTo(EloquentEspecialidade::class, 'especialidade_id', 'especialidade_id');
    }
}