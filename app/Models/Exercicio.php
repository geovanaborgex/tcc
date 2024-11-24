<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercicio extends Model
{
    use HasFactory;

    // Se necessário, defina a tabela explicitamente
    protected $table = 'exercicio';

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = ['nome', 'series', 'repeticoes', 'carga', 'observacao', 'treino_id'];

    // Relacionamento com o treino (um exercício pertence a um treino)
    public function treino()
    {
        return $this->belongsTo(Treino::class, 'treino_id');
    }
}
