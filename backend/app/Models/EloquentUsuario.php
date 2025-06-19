<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EloquentUsuario extends Authenticatable
{
    use HasFactory;

    /**
     * O nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * A chave primária da tabela.
     *
     * @var string
     */
    protected $primaryKey = 'usuario_id';

    /**
     * Indica se a chave primária é auto-incrementável.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * O tipo da chave primária.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * As colunas que podem ser preenchidas em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
        'senha',
        'admin',
        'data_criacao',
        'data_atualizacao',
    ];

    /**
     * As colunas que devem ser ocultadas para arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array<string, string>
     */
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

    public function getAuthPassword(): string
    {
        return $this->senha;
    }
}