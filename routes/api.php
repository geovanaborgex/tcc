<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiController::class, 'logout']);
    Route::get('/user/perfil', [ApiController::class, 'perfil']);
    Route::put('/user/edit', [ApiController::class, 'updatePerfil']);
    Route::get('/aluno/treinos', [ApiController::class, 'visualizarTreinosAlunoLogado']);
});
