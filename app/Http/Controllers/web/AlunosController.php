<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Contrato;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Log;

class AlunosController extends Controller
{
    public function alunos(){
        return view('alunos');
    }
    
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

            return redirect()->route('alunos.index')->with('success', 'Aluno inserido com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('alunos.index')->with('error', 'Erro ao inserir o aluno!');
        }
    }

    public function alunosDoProfissional(Request $request)
    {
        $profissionalId = auth()->user()->profissional_id;
    
        // Obtem contratos relacionados ao profissional
        $contratos = Contrato::where('profissional_id', $profissionalId)
            ->with(['aluno', 'aluno.user']) // Carrega relações aluno e user
            ->get();
    
        // Filtra alunos relacionados ao profissional
        $alunos = $contratos->pluck('aluno')->unique('id'); // Evita duplicatas
    
        // Aplica filtro de busca nos alunos
        if ($request->has('search') && !empty($request->search)) {
            \Log::info('Nome a pesquisar: ' . $request->search); // Loga o valor recebido no parâmetro
    
            $search = trim(preg_replace('/\s+/', ' ', $request->search));
    
            // Filtra a coleção de alunos pelo nome
            $alunos = $alunos->filter(function ($aluno) use ($search) {
                return stripos($aluno->user->name ?? '', $search) !== false;
            });
        }
    
        // Paginação manual para a coleção filtrada
        $alunos = $alunos->values(); // Reindexa os elementos após o filtro
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $paginatedAlunos = new \Illuminate\Pagination\LengthAwarePaginator(
            $alunos->forPage($currentPage, $perPage),
            $alunos->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    
        return view('alunos', ['alunos' => $paginatedAlunos]);
    }
    

    public function update(Request $request, $id)
    {
        // Logando a requisição recebida
        Log::info("Iniciando a atualização do aluno com ID: {$id}");

        $request->validate([
            'name' => 'string|max:255',
            'telefone' => 'nullable|string|max:45',
            'peso' => 'nullable|numeric',
            'altura' => 'nullable|numeric',
            'password' => 'nullable|string|min:8',
        ]);

        // Logando as informações validadas
        Log::info("Dados validados para o aluno: ", $request->all());

        try {
            // Busca o aluno pelo ID
            $aluno = Aluno::findOrFail($id);
            Log::info("Aluno encontrado: ", ['aluno' => $aluno]);

            // Atualiza os campos do aluno apenas se foram enviados
            $aluno->telefone = $request->filled('telefone') ? $request->telefone : $aluno->telefone;
            $aluno->peso = $request->filled('peso') ? $request->peso : $aluno->peso;
            $aluno->altura = $request->filled('altura') ? $request->altura : $aluno->altura;
            $aluno->save();

            Log::info("Aluno atualizado com sucesso: ", ['aluno' => $aluno]);

            // Busca o usuário associado ao aluno
            $usuario = User::where('aluno_id', $id)->firstOrFail();
            Log::info("Usuário encontrado para o aluno: ", ['usuario' => $usuario]);

            // Atualiza os campos do usuário apenas se foram enviados
            $usuario->name = $request->filled('name') ? $request->name : $usuario->name;

            $usuario->save();

            Log::info("Usuário atualizado com sucesso: ", ['usuario' => $usuario]);

            return redirect()->route('alunos.index')->with('success', 'Aluno atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar aluno com ID {$id}: " . $e->getMessage());
            return redirect()->route('alunos.index')->with('error', 'Erro ao atualizar o aluno!');
        }
    }
    
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
    
            // Mensagem de sucesso
            session()->flash('success', 'Aluno excluído com sucesso!');
    
            return redirect()->route('alunos.index'); // Redireciona após a exclusão
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
}
