<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\TreinoController;
use App\Http\Controllers\web\FichasController;
use App\Http\Controllers\web\IndexLogadoController;
use App\Http\Controllers\web\LoginController;
use App\Http\Controllers\web\PerfilController;
use App\Http\Controllers\web\PrincipalController;
use App\Http\Controllers\web\TreinoAlunoController;
use App\Http\Controllers\web\AlunosController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;


//--------------------------------------------------------------------------------------------------------------------------------
//----------------Rotas abertas que qualquer usuario pode acessar
Route::get('/', [PrincipalController::class, 'principal']);

//verificacao do cadastro
Route::post('/cadastrar', [LoginController::class, 'cadastrar'])->name('cadastro');
Route::get('/login', [LoginController::class, 'login'])->name('login');

//verificacao do login
Route::post('/login', [LoginController::class, 'realizarLogin'])->name('logar');

//esqueceu senha jetstream
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->name('password.update');


//--------------------------------------------------------------------------------------------------------------------------------
//-----------------Rotas acessíveis apenas por usuários PROFISSIONAIS
Route::middleware(['auth', 'verificar_tipo:P', 'PreventBackHistory'])->group(function () {
    
    Route::get('/alunos', [AlunosController::class, 'alunos']);

    //trabalhando com alunos(criaçao e vizualização)
    Route::get('/alunos', [AlunosController::class, 'alunosDoProfissional'])->name('alunos.index');
    Route::post('/alunos', [AlunosController::class, 'store'])->name('alunos.store');
    Route::put('/alunos/{id}', [AlunosController::class, 'update'])->name('alunos.update');
    Route::delete('alunos/{id}', [AlunosController::class, 'destroy'])->name('alunos.destroy');

    //trabalhando com treino
    Route::get('/treino/criar/{contrato_id}', [TreinoController::class, 'index'])->name('criartreino');
    Route::post('/treinoCriar', [TreinoController::class, 'store'])->name('treinos.store');
    Route::get('/treinos/{contrato_id}', [TreinoController::class, 'getTreinos'])->name('treinos.show');
    Route::delete('/treinos/{id}', [TreinoController::class, 'destroy'])->name('treinos.destroy');
    Route::get('/treinos/{id}/edit', [TreinoController::class, 'edit']);
    Route::put('/treinos/{id}', [TreinoController::class, 'update']);
    
});


//--------------------------------------------------------------------------------------------------------------------------------
//-----------------Rotas acessíveis apenas por usuários ALUNOS
Route::middleware(['auth', 'verificar_tipo:A', 'PreventBackHistory'])->group(function () {
    Route::get('/fichas', [FichasController::class, 'fichas']);

    //mostrar as fichas pro usuario(aluno) logado 
    Route::get('/fichas/', [FichasController::class, 'index'])->name('fichas');

    Route::get('/treino-aluno', [TreinoAlunoController::class, 'treinoAluno']);

});


//--------------------------------------------------------------------------------------------------------------------------------
//----------------Rotas que permitem acesso de ambos tipos de usuários
Route::middleware(['auth', 'PreventBackHistory'])->group(function () {
    Route::get('/logado', [IndexLogadoController::class, 'indexLogado'])->name('logado');
    Route::get('/perfil', [PerfilController::class, 'perfil']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');   
    Route::post('/perfil', [PerfilController::class, 'update'])->name('editarPerfil');
});

