@extends('layouts.main')

@section('content')

<style>
    /* Estilos globais */
    body {
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    h2 {
        background-color: #6a0dad;
        color: #fff;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
    }

    .treino-card {
        background-color: #fff;
        border: 2px solid #6a0dad;
        border-radius: 10px;
        margin-bottom: 20px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #6a0dad;
        color: white;
    }

    td {
        background-color: #f9f9f9;
    }

    .observacoes {
        margin-top: 10px;
        font-style: italic;
    }

    .highlight {
        background-color: #ffd700;
    }
</style>
<br>
<h2>Fichas de Treino</h2>

<div id="treinos-container">
    @if($treinos->isNotEmpty())
        @foreach($treinos as $treino)
            <div class="treino-card">
                <h2>Treino: {{ $treino->categoria }}</h2>
                <table>
                    <thead>
            
                        <tr>
                            <th>Exercício</th>
                            <th>Séries</th>
                            <th>Repetições</th>
                            <th>Carga</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($treino->exercicios as $exercicio)
                            <tr>
                                <td>{{ $exercicio->nome }}</td>
                                <td>{{ $exercicio->series }}</td>
                                <td>{{ $exercicio->repeticoes }}</td>
                                <td>{{ $exercicio->carga ?? '---' }}</td>
                                <td>{{ $exercicio->observacao }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @else
        <p>Nenhum treino encontrado para este contrato.</p>
    @endif
</div>

@endsection
