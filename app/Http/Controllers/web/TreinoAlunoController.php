<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;

class TreinoAlunoController extends Controller
{
    public function treinoAluno(){
        return view('treinoAluno');
    }
}
