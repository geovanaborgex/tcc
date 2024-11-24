<?php

namespace App\Http\Controllers;
use App\Models\Treino;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    function login(Request $request) {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Dados de Login Inválidos'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login realizado com sucesso!',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'tokenAuth' => $token,
            ],
        ]);
        

    }

    function logout(Request $Request){
        //PEGA O USUÁRIO LOGADO, DELETA SEUS TOKENS E O DESLOGA.
        $user = Auth::user();
        $user->tokens()->delete();
        auth()->guard('web')->logout();
        return response()->json(['message' => 'Usuario efetuou logout'],200);
    }

    public function visualizarTreinosAlunoLogado(Request $request)
    {
         // Obtenha o usuário autenticado
    $user = $request->user();

    // Pegue o aluno_id associado ao usuário autenticado
    $alunoId = $user->aluno_id;

    if (!$alunoId) {
        return response()->json([
            'status' => 'error',
            'message' => 'Aluno não encontrado para o usuário logado.'
        ], 404);
    }

    // Busca os treinos com os exercícios relacionados
    $treinos = Treino::with('exercicios') // Carrega os exercícios relacionados
        ->whereHas('contrato', function ($query) use ($alunoId) {
            $query->where('aluno_id', $alunoId);
        })
        ->get();

    // Retorna os treinos com os exercícios
    return response()->json([
        'status' => 'success',
        'treinos' => $treinos
    ]);
    }

    function atualizarToken(Request $Request){
        //PEGA O USUÁRIO LOGADO, DELETA SEUS TOKENS
        $user = Auth::user();
        $user->tokens()->delete();

        //CRIA UM NOVO TOKEN E O RETORNA COMO JSON
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}

