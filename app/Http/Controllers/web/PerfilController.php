<?php
namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Log;

class PerfilController extends Controller
{
    // Método para chamar a view perfil
    public function perfil()
    {
        $usuario = Auth::user();

    // Carregar os dados específicos de Profissional ou Aluno
    if ($usuario->tipo == 'P') {
        $profissional = $usuario->profissional; // Relacionamento Profissional
        return view('perfil', compact('profissional'));
    } elseif ($usuario->tipo == 'A') {
        $aluno = $usuario->aluno; // Relacionamento Aluno
        return view('perfil', compact('aluno'));
    }

    return view('perfil');
    }

    // Método para editar o perfil com base no usuário logado
    public function update(Request $request)
    {
        // Obter o usuário autenticado
        $usuario = Auth::user();
        
        // Log para ver o usuário autenticado
        Log::info('Usuário autenticado: ' . $usuario->name . ' - ID: ' . $usuario->id);

        // Validar os dados do formulário
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'senha' => 'nullable|min:6',
        ]);

        // Log para verificar os dados do request
        Log::info('Dados do request para atualização:', $request->all());

        // Atualizar o perfil do usuário
        $usuario->name = $request->input('nome');
        $usuario->email = $request->input('email');

        // Verifica se uma nova senha foi fornecida e atualiza se necessário
        if ($request->filled('senha')) {
            Log::info('Atualizando senha do usuário: ' . $usuario->id);
            $usuario->password = Hash::make($request->input('senha')); // Hash da nova senha
        }

        // Verifica o tipo de usuário e atualiza os dados correspondentes
        if ($usuario->tipo == 'P') {
            $profissional = $usuario->profissional;  // Obter o profissional associado ao usuário
            Log::info('Atualizando dados do profissional. ID: ' . $profissional->id);

            // Atualizar campos de formação e biografia
            $profissional->formacao = $request->input('formacao');
            $profissional->biografia = $request->input('biografia');
            $profissional->save();  // Salvar os dados do profissional

            Log::info('Dados do profissional atualizados: ', [
                'formacao' => $profissional->formacao,
                'biografia' => $profissional->biografia
            ]);
        } elseif ($usuario->tipo == 'A') {
            $aluno = $usuario->aluno;  // Obter o aluno associado ao usuário
            Log::info('Atualizando dados do aluno. ID: ' . $aluno->id);

            // Atualizar campos de telefone, peso, altura e biografia
            $aluno->telefone = $request->input('telefone');
            $aluno->peso = $request->input('peso');
            $aluno->altura = $request->input('altura');
            $aluno->biografia = $request->input('biografia');
            $aluno->save();  // Salvar os dados do aluno

            Log::info('Dados do aluno atualizados: ', [
                'telefone' => $aluno->telefone,
                'peso' => $aluno->peso,
                'altura' => $aluno->altura,
                'biografia' => $aluno->biografia
            ]);
        }

        // Salvar as alterações no usuário
        $usuario->save();

        // Log para confirmar que a atualização foi bem-sucedida
        Log::info('Perfil do usuário atualizado com sucesso: ' . $usuario->id);

        // Redirecionar com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }
}
