<?php

namespace App\Http\Controllers;
use App\Models\Treino;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

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

    public function perfil(Request $request)
{
    // Obter o usuário autenticado
    $usuario = Auth::user();

    // Verifica o tipo de usuário e prepara os dados de acordo
    if ($usuario->tipo == 'P') {
        $profissional = $usuario->profissional;  // Obter o profissional associado ao usuário
        $userData = [
            'name' => $usuario->name,
            'email' => $usuario->email,
            'formacao' => $profissional->formacao ?? '',
            'biografia' => $profissional->biografia ?? '',
            'telefone' => $usuario->telefone ?? '',
            'peso' => $usuario->peso ?? '',
            'altura' => $usuario->altura ?? '',
        ];
    } elseif ($usuario->tipo == 'A') {
        $aluno = $usuario->aluno;  // Obter o aluno associado ao usuário
        $userData = [
            'name' => $usuario->name,
            'email' => $usuario->email,
            'formacao' => $aluno->formacao ?? '',
            'biografia' => $aluno->biografia ?? '',
            'telefone' => $aluno->telefone ?? '',
            'peso' => $aluno->peso ?? '',
            'altura' => $aluno->altura ?? '',
        ];
    }

    // Retorna os dados em formato JSON
    return response()->json([
        'success' => true,
        'data' => $userData,
    ]);
}

public function updatePerfil(Request $request)
{
    // Obter o usuário autenticado
    $usuario = Auth::user();

    // Verificar se o usuário é do tipo Aluno
    if ($usuario->tipo != 'A') {
        return response()->json([
            'success' => false,
            'message' => 'Acesso não autorizado.',
        ], 403);
    }

    // Validação dos dados recebidos
    $request->validate([
        'nome' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $usuario->id,
        'senha' => 'nullable|string|min:6',
        'biografia' => 'nullable|string',
        'telefone' => 'nullable|string|max:20',
        'peso' => 'nullable|numeric|min:0',
        'altura' => 'nullable|numeric|min:0',
    ]);

    // Atualizar os dados do usuário
    $usuario->name = $request->input('nome');
    $usuario->email = $request->input('email');

    // Atualizar a senha se fornecida
    if ($request->filled('senha')) {
        $usuario->password = Hash::make($request->input('senha'));
    }

    // Obter o Aluno associado e atualizar os dados
    $aluno = $usuario->aluno; // Relacionamento com o modelo Aluno
    if ($aluno) {
        $aluno->biografia = $request->input('biografia');
        $aluno->telefone = $request->input('telefone');
        $aluno->peso = $request->input('peso');
        $aluno->altura = $request->input('altura');
        $aluno->save();
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Dados do aluno não encontrados.',
        ], 404);
    }

    // Salvar as alterações do usuário
    $usuario->save();

    // Retornar resposta de sucesso
    return response()->json([
        'success' => true,
        'message' => 'Perfil atualizado com sucesso!',
        'data' => [
            'nome' => $usuario->name,
            'email' => $usuario->email,
            'biografia' => $aluno->biografia ?? '',
            'telefone' => $aluno->telefone ?? '',
            'peso' => $aluno->peso ?? '',
            'altura' => $aluno->altura ?? '',
        ],
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

