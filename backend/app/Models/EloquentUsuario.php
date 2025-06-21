<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EloquentUsuario extends Authenticatable
{
    use HasFactory;


    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'admin',
        'data_criacao',
        'data_atualizacao',
    ];

    protected $hidden = [
        'senha',
    ];

    protected $casts = [
        'admin' => 'boolean',
        'data_criacao' => 'datetime',
        'data_atualizacao' => 'datetime',
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->data_criacao = $model->freshTimestamp();
            $model->data_atualizacao = $model->freshTimestamp();
        });

        static::updating(function ($model) {
            $model->data_atualizacao = $model->freshTimestamp();
        });
    }
    
    public function agendamentos(): HasMany
    {
        return $this->hasMany(EloquentAgendamento::class, 'usuario_id', 'usuario_id');
    }

    public function getAuthPassword(): string
    {
        return $this->senha;
    }
}