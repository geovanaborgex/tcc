<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Contrato;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AlunosController extends Controller
{
    // Mostrar view alunos
    public function alunos(){
        return view('alunos');
    }

    // Mostrar alunos cadastrados 
    public function index(Request $request)
    {
        $search = $request->get('search'); // Obtém o parâmetro de pesquisa da query string
        
        $alunos = Aluno::with('user', 'contrato')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->get();
        
        return view('alunos.index', compact('alunos'));
    }
    
    // Adicionando um novo aluno
    public function store(Request $request)
    {
        try {
            // Validação dos dados
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'telefone' => 'required|string|max:45',
                'peso' => 'required|numeric',
                'altura' => 'required|numeric',
                'termino' => 'required|date'
            ]);

            // Criar um novo aluno
            $aluno = new Aluno();
            $aluno->telefone = $request->telefone;
            $aluno->peso = $request->peso;
            $aluno->altura = $request->altura;

         
            // Salvar o aluno
            $aluno->save();

            // Adicionar o nome, email e senha à tabela 'users'
            $usuario = new User();
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password = bcrypt($request->password);
            $usuario->tipo = 'A';
            $usuario->aluno_id = $aluno->id;

            if (Auth::user()->tipo === 'P') {
                $usuario->profissional_id = Auth::user()->profissional_id;
            }

            $usuario->save();

            if (Auth::user()->tipo === 'P') {
                $contrato = new Contrato();
                $contrato->aluno_id = $aluno->id;
                $contrato->profissional_id = Auth::user()->profissional_id;
                $contrato->data_inicio = now();
                $contrato->data_termino = $request->termino;
                $contrato->save();
            }

            return response()->json(['message' => 'Aluno adicionado com sucesso!'], 201);
        } catch (\Exception $e) {
            \Log::error('Erro ao adicionar contrato: ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao adicionar aluno: ' . $e->getMessage()], 500);
        }
    }

    // Alunos do profissional logado
    public function alunosDoProfissional()
    {
        $profissionalId = auth()->user()->profissional_id;
        $contratos = Contrato::where('profissional_id', $profissionalId)->with('aluno')->get();
        $alunos = $contratos->pluck('aluno')->unique('id');

        return view('alunos', compact('alunos'));
    }

    // Editar um aluno existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $id,
            'telefone' => 'nullable|string|max:45',
            'peso' => 'nullable|numeric',
            'altura' => 'nullable|numeric',
            'password' => 'nullable|string|min:8',
        ]);
    
        // Busca o aluno pelo ID
        $aluno = Aluno::findOrFail($id);
    
        // Atualiza os campos do aluno apenas se foram enviados
        $aluno->telefone = $request->filled('telefone') ? $request->telefone : $aluno->telefone;
        $aluno->peso = $request->filled('peso') ? $request->peso : $aluno->peso;
        $aluno->altura = $request->filled('altura') ? $request->altura : $aluno->altura;
        $aluno->save();
    
        // Busca o usuário associado ao aluno
        $usuario = User::where('aluno_id', $id)->firstOrFail();
    
        // Atualiza os campos do usuário apenas se foram enviados
        $usuario->name = $request->filled('name') ? $request->name : $usuario->name;
        $usuario->email = $request->filled('email') ? $request->email : $usuario->email;
    
        // Atualiza a senha se foi preenchida
        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->password);
        }
    
        $usuario->save();
    
        return response()->json(['message' => 'Aluno atualizado com sucesso!']);
    }
    
    // Excluir um aluno
    public function destroy($id)
{
    try {
        $aluno = Aluno::findOrFail($id); // Encontra o aluno pelo ID

         // Verifica se o aluno está referenciado em users e deleta
         $user = User::where('aluno_id', $aluno->id)->first();
         if ($user) {
             $user->delete(); // Exclui o registro na tabela users
         }

        // Verifica se o aluno tem contratos
        if ($aluno->contrato()->exists()) {
            foreach ($aluno->contrato as $contrato) {
                // Verifica se o contrato tem treinos
                if ($contrato->treino()->exists()) {
                    foreach ($contrato->treino as $treino) {
                        // Verifica se o treino tem exercícios
                        if ($treino->exercicio()->exists()) {
                            $treino->exercicio()->delete(); // Deleta os exercícios associados ao treino
                        }
                    }
                    $contrato->treino()->delete(); // Exclui os treinos relacionados ao contrato
                }
            }
            $aluno->contrato()->delete(); // Exclui os contratos associados ao aluno
        }

        // Exclui o aluno
        $aluno->delete();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}

    
    

    
}
