<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\User;
use App\Models\Profissional; // Adicione este import para o model Profissional
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function cadastrar(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required|string|max:80',
            'tipo' => 'required|in:A,P', // 'A' para aluno, 'P' para profissional
        ]);
    
        // Criação do usuário no banco
        $usuario = new User();
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);      
        $usuario->name = $request->name;
        $usuario->tipo = $request->tipo;
        $usuario->save();
    
        // Se o tipo for 'P' (profissional), criar automaticamente um registro em 'profissionais'
        if ($usuario->tipo === 'P') {
            // Criar o registro na tabela 'profissionais'
            $profissional = new Profissional();
            $profissional->save();
    
            // Atualizar o campo 'profissional_id' no usuário com o ID do profissional criado
            $usuario->profissional_id = $profissional->id;
            $usuario->save();
        }
    
        // Se o tipo for 'A' (aluno), criar um registro em 'alunos'
        if ($usuario->tipo === 'A') {
            $aluno = new Aluno();
            $aluno->save();
    
            // Atualizar o campo 'aluno_id' no usuário com o ID do aluno criado
            $usuario->aluno_id = $aluno->id;
            $usuario->save();
        }
    
        // Retornar uma resposta de sucesso ou redirecionar conforme sua lógica
        return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso!');
    }
    public function logout(Request $request)
    {
        Auth::logout(); // Desloga o usuário.
        Session::flush(); // Limpa a sessão.
        
        $request->session()->invalidate(); // Invalida a sessão atual.
        $request->session()->regenerateToken(); // Regenera o token CSRF.
    
        return redirect('/login')->with('status', 'Você saiu com sucesso!');
    }
    
    

    public function realizarLogin(Request $request)
    {
        // Validação das credenciais
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $usuario = User::where('email', $request->email)->first();

        // Tentativa de autenticação
        if ($usuario && Hash::check($request->password, $usuario->password)) {
            Auth::login($usuario); // Login manual
            
            // Verifique o tipo de usuário e redirecione para a rota apropriada
            if ($usuario->tipo === 'A') {
                return redirect()->route('logado'); // Altere para sua rota de aluno
            } elseif ($usuario->tipo === 'P') {
                return redirect()->route('logado'); // Altere para sua rota de professor
            }
        }

        // Se a autenticação falhar, redirecione de volta com uma mensagem de erro
        return redirect()->back()->withErrors(['email' => 'As credenciais fornecidas não são válidas.']);
    }

    public function atualizarProfissionalId(User $usuario)
    {
        // Verifica se o usuário já tem um profissional_id nulo
        if (is_null($usuario->profissional_id)) {
            $usuario->profissional_id = Auth::user()->id; // Atualiza com o ID do profissional logado
            $usuario->save(); // Salva as alterações
        }
    }
}
