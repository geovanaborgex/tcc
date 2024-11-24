<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{

    protected $table = 'aluno';

    protected $fillable = [
        'nome',
        'telefone',
        'peso',
        'altura',
        'biografia',
    ];

    // Define a relação com o modelo User
    public function user()
    {
        return $this->hasOne(User::class, 'aluno_id');
    }
    

    public function contrato()
    {
        return $this->hasMany(Contrato::class, 'aluno_id');
    }
}