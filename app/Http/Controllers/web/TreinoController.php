<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\Exercicio;
use App\Models\Treino;
use DB;
use Illuminate\Http\Request;
use Log;

class TreinoController extends Controller
{
    
   public function index($contrato_id)
   {
       // Buscar o contrato pelo ID fornecido e carregar as relações 'aluno' e 'profissional'
       $contrato = Contrato::with(['aluno', 'profissional'])->find($contrato_id);

       $nomea = DB::table('users as u')
       ->join('aluno as a', 'u.aluno_id', 'a.id')
       ->join('contrato as c', 'a.id', 'c.aluno_id')
       ->where('c.id', $contrato-> id)
       ->select('u.name', 'a.id')
       ->first();

       $nomep = DB::table('users as u')
       ->join('profissional as p', 'u.profissional_id', 'p.id')
       ->join('contrato as c', 'p.id', 'c.profissional_id')
       ->where('c.id', $contrato->id)
       ->where('c.aluno_id', $nomea->id)
       ->select('u.name')
       ->first();
   
       // Passar as informações para a view
       return view('treinoCriar', [
            'contrato' => $contrato,
            'nomeAluno' => $nomea->name,
            'nomeProf' => $nomep->name,
       ]);
   }
   
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'categoria' => 'required|string',
            'contrato_id' => 'required',
            'exercicios' => 'required|array',
            'exercicios.*.nome' => 'required|string',
            'exercicios.*.series' => 'required|integer',
            'exercicios.*.repeticoes' => 'required|integer',
            'exercicios.*.carga' => 'required|integer',
            'exercicios.*.observacao' => 'required|string',
        ]);
    
        // Criar o treino
        $treino = Treino::create([
            'categoria' => $request->input('categoria'),
            'contrato_id' => $request->input('contrato_id')
        ]);
    
       // Adiciona os exercícios
            $exercicios = $request->input('exercicios');
            foreach ($exercicios as $exercicio) {
                Exercicio::create([
                    'treino_id' => $treino->id,
                    'nome' => $exercicio['nome'],
                    'series' => $exercicio['series'],
                    'repeticoes' => $exercicio['repeticoes'], 
                    'carga' => $exercicio['carga'],
                    'observacao' => $exercicio['observacao'] ?? '', // Observação é opcional
                ]);
            }

  // Redirecionar de volta com mensagem de sucesso
        return response()->json(['success' => false, 'message' => 'Aluno não encontrado.']);

}

    public function getTreinos($contrato_id)
    {
    try {
        Log::info("Iniciando busca de treinos para o contrato com ID: " . $contrato_id);

        // Verifica se o contrato realmente existe
        $contrato = Contrato::find($contrato_id);
        if (!$contrato) {
            Log::error("Contrato não encontrado para o ID: " . $contrato_id);
            return response()->json(['error' => 'Contrato não encontrado.'], 404);
        }

        // Agora vamos buscar os treinos para o contrato
        $treinos = Treino::where('contrato_id', $contrato_id)
                        ->with('exercicios')
                        ->get();

        // Verifica se algum treino foi encontrado
        if ($treinos->isEmpty()) {
            Log::info("Nenhum treino encontrado para o contrato com ID: " . $contrato_id);
            return response()->json(['message' => 'Nenhum treino encontrado para este contrato.'], 404);
        }

        // Log para ver os treinos que foram encontrados
        Log::info("Treinos encontrados: ", $treinos->toArray());

        return response()->json($treinos);

    } catch (\Exception $e) {
        Log::error("Erro ao buscar treinos para o contrato " . $contrato_id . ": " . $e->getMessage());
        return response()->json(['error' => 'Erro ao buscar treinos.'], 500);
    }
}
public function edit($id)
{
    $treino = Treino::with('exercicios')->findOrFail($id);
    return response()->json($treino);
}

public function update(Request $request, $id)
{
    // Log básico para verificar se a requisição chegou
    Log::info('Entrou no método update do controller', ['id' => $id, 'payload' => $request->all()]);

    try {
        // Encontrar o treino pelo ID
        $treino = Treino::findOrFail($id);

        // Logar o treino encontrado
        Log::info('Treino encontrado', ['treino' => $treino]);

        // Busca o treino e atualiza a categoria
        $treino->categoria = $request->input('category');
        $treino->save();

        // Log para verificar se a categoria foi salva
        Log::info('Categoria atualizada para:', ['categoria' => $treino->categoria]);

        // Remover os exercícios antigos e adicionar os novos
        $treino->exercicios()->delete(); // Certifique-se de que a relação `exercicios` está configurada

        $exercicios = $request->input('exercicios', []);

        foreach ($exercicios as $exercicio) {
            $treino->exercicios()->create($exercicio);
            Log::info('Exercício adicionado', ['exercicio' => $exercicio]);
        }

        return response()->json(['status' => 'success', 'message' => 'Treino atualizado com sucesso!']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Erro ao atualizar o treino!']);
    }
}


    public function destroy($id)
    {
        $treino = Treino::findOrFail($id);
    
        if ($treino) {
            // Apaga todos os exercícios relacionados ao treino
            $treino->exercicios()->delete();
            
            // Apaga o treino
            $treino->delete();
    
            return response()->json(['success' => 'Treino deletado com sucesso']);
        }
    
        return response()->json(['error' => 'Erro ao deletar treino'], 500);}
    
}
