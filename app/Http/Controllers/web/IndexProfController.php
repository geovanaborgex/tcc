<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexProfController extends Controller
{
    public function indexProf(){
        return view('indexProf');
    }
}
