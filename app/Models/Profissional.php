<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
    use HasFactory;
    protected $table = 'profissional';

    // Defina os campos que podem ser preenchidos
    protected $fillable = [
        'formacao',  
        'biografia',   
    ];

    // Define a relação com o modelo User
    // Define a relação com o modelo User
    public function user()
    {
        return $this->hasOne(User::class, 'aluno_id');
    }

    public function contrato()
    {
        return $this->hasMany(Contrato::class, 'profissional_id');
    }
}
