<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\Treino;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FichasController extends Controller
{
    public function index()
    {
        try {
            // Obtém o usuário logado
            $usuario = Auth::user();

            // Verifica se o usuário logado é realmente um aluno e acessa o aluno_id
            if (!$usuario || !$usuario->aluno) {
                \Log::error("Nenhum aluno encontrado para o usuário logado.");
                return response()->json(['error' => 'Aluno não encontrado para este usuário.'], 403);
            }

            // Pegando o aluno_id do aluno relacionado ao usuário logado
            $aluno_id = $usuario->aluno->id;

            // Verifica se o aluno existe
            \Log::info("Aluno logado com ID: ", ['aluno_id' => $aluno_id]);

            // Encontra o contrato do aluno logado
            $contrato = Contrato::where('aluno_id', $aluno_id)->first();

            // Verifica se o contrato foi encontrado
            if (is_null($contrato)) {
                \Log::error("Contrato não encontrado para o aluno com ID: " . $aluno_id);
                return response()->json(['error' => 'Contrato não encontrado para este aluno.'], 404);
            }

            // Agora que temos o contrato, podemos acessar o ID dele
            $contrato_id = $contrato->id;

            // Recupera os treinos relacionados ao contrato
            $treinos = Treino::where('contrato_id', $contrato_id)
                             ->with('exercicios')
                             ->get();

            // Verifica se os treinos foram encontrados
            if ($treinos->isEmpty()) {
                \Log::info("Nenhum treino encontrado para o contrato com ID: " . $contrato_id);
                return response()->json(['message' => 'Nenhum treino encontrado para este contrato.'], 404);
            }

            // Retorna a view 'fichas' com os dados dos treinos
            return view('fichas', compact('treinos'));

        } catch (\Exception $e) {
            \Log::error("Erro ao buscar treinos: " . $e->getMessage());
            return response()->json(['error' => 'Erro ao buscar treinos.'], 500);
        }
    }
}
