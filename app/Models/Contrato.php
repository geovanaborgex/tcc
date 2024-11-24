<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = 'contrato';

    protected $fillable = [
        'aluno_id',
        'profissional_id',
        'data_inicio',
        'data_termino',
    ];

    // Define o relacionamento com o Aluno
    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id');
    }

    // Define o relacionamento com o Profissional
    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }

    // App\Models\Contrato.php

public function alunoUser()
{
    return $this->belongsTo(User::class, 'aluno_id'); // Aluno associado
}

public function profissionalUser()
{
    return $this->belongsTo(User::class, 'profissional_id'); // Profissional associado
}

            // App\Models\Contrato.php
        public function treino()
        {
            return $this->hasMany(Treino::class, 'contrato_id');
        }

}
