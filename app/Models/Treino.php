<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treino extends Model
{
    use HasFactory;

    // Se necessário, defina a tabela explicitamente
    protected $table = 'treino';

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = ['categoria', 'contrato_id'];

    // Relacionamento com os exercícios (um treino pode ter muitos exercícios)
    public function exercicios()
    {
        return $this->hasMany(Exercicio::class);
    }

    // Relacionamento com o contrato
   // App\Models\Treino.php
public function contrato()
{
    return $this->belongsTo(Contrato::class, 'contrato_id');
}

}
