@extends('layouts.main')

@section('content')


<style>

    .add-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        position: fixed;
        margin-top: 30px;
        right: 50px;
        font-size: 18px;
    }

   
    .add-buttonn {
        background-color: #691bc2e6;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 14px;
    }
   
     /* Estilos gerais para o modal */
     .modal {
        display: none; /* Esconde o modal por padrão */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background-color: #fff;
        width: 90%;
        max-width: 500px;
        max-height: 80%; /* Limita a altura para 80% da tela */
        overflow-y: auto; /* Adiciona barra de rolagem se o conteúdo ultrapassar a altura */
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.5em;
    }

    .close-btn {
        cursor: pointer;
        font-size: 1.5em;
        color: #333;
    }

    .modal-body {
        max-height: 60vh; /* Limita a altura da área de conteúdo */
        overflow-y: auto; /* Adiciona rolagem interna */
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    /* Estilos do formulário */
    form label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }

    form input {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    form button[type="submit"] {
        padding: 5px 13px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }

    form button[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<div class="page-body">
    <div class="container-xl">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="card card-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 my-5" style="color: #691bc2e6;">
                        <h1 style="margin-left: 20px;">Alunos em monitoramento</h1>
                        <button class="add-button" id="addAlunoBtn">Adicionar aluno</button>
                         <!-- Campo de pesquisa -->
                         <form method="GET" action="{{ route('alunos.index') }}" style="margin-bottom: 20px;">
                            <input type="text" name="search" placeholder="Buscar aluno..." value="{{ request('search') }}" style="padding: 8px; width: 300px; border-radius: 4px; border: 1px solid #ccc;">
                            <button type="submit" class="add-buttonn" style="margin-left: 10px;">Pesquisar</button>
                        </form>
                        </div>
                    </div>
                </div>
                <table class="table table-transparent table-responsive">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 1%"></th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Data de Início</th>
                            <th>Data de Término</th>
                            <th>Treino</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alunos as $aluno)
                            @foreach($aluno->contrato as $contrato)
                                <tr>
                                    <td class="text-center">{{ $loop->parent->iteration }}</td>
                                    <td>{{ $aluno->user ? $aluno->user->name : 'Nome não encontrado' }}</td>
                                    <td>{{ $aluno->user ? $aluno->user->email : 'Email não encontrado' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($contrato->data_inicio)->format('d/m/Y') ?? 'Data não encontrada' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($contrato->data_termino)->format('d/m/Y') ?? 'Data não encontrada' }}</td>
                                    <td><button class="add-buttonn" onclick="window.location.href='{{ route('criartreino', ['contrato_id' => $contrato->id]) }}'">Adicionar treino</button></td>
                                    <td>
                                        <button class="add-buttonn" onclick="openEditModal({{ $aluno }})">✏️ Editar</button>
                                        <form id="deleteAluno({{ $aluno->id }})" action="{{ route('alunos.destroy', $aluno->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style=" background-color: #691bc2e6;" class="add-buttonn">🗑️ Deletar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Nenhum aluno encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal adicionar aluno -->
<div id="addAlunoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Adicionar Aluno</h2>
            <span class="close-btn">&times;</span>
        </div>
        <div class="modal-body">
            <form id="addAlunoForm" method="POST" action="{{ route('alunos.store') }}" enctype="multipart/form-data">
                @csrf

                        <label for="name">Nome:</label>
                        <input type="text" id="name" name="name" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="password">Senha:</label>
                        <input type="password" id="password" name="password" required>
                
                        <label for="telefone">Telefone:</label>
                        <input type="tel" id="telefone" name="telefone" required>
                        
                        <label for="peso">Peso (kg):</label>
                        <input type="number" id="peso" name="peso" step="0.1" required>

                        <label for="peso">Data de término do contrato:</label>
                        <input type="date" id="termino" name="termino" required>

                        <label for="altura">Altura (m):</label>
                        <input type="number" id="altura" name="altura" step="0.01" required>

                        <div class="modal-footer">
                            <button type="submit">Salvar</button>
                        </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal editar aluno -->
<div id="editAlunoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Editar Aluno</h2>
            <span class="close-btn">&times;</span>
        </div>
        <div class="modal-body">
        <form id="editAlunoForm" method="POST" action="" enctype="multipart/form-data">
    @csrf
    @method('PUT')
                <input type="hidden" id="editAlunoId" name="id">
                
                <label for="name">Nome:</label>
                <input type="text" id="editName" name="name" >

                <label for="email">Email:</label>
                <input type="email" id="editEmail" name="email" >

                <label for="telefone">Telefone:</label>
                <input type="tel" id="editTelefone" name="telefone" >

                <label for="peso">Peso (kg):</label>
                <input type="number" id="editPeso" name="peso" step="0.1" >

                <label for="altura">Altura (m):</label>
                <input type="number" id="editAltura" name="altura" step="0.01" >

                <div class="modal-footer">
                    <button type="submit">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('addAlunoBtn').onclick = function() {
        document.getElementById('addAlunoModal').style.display = 'flex';
    };

    document.querySelectorAll('.close-btn').forEach(btn => {
        btn.onclick = function() {
            btn.closest('.modal').style.display = 'none';
        };
    });

    function openEditModal(aluno) {
    const editAlunoModal = document.getElementById('editAlunoModal');
    editAlunoModal.style.display = 'flex';

    // Preenche os campos do formulário com os dados do aluno
    document.getElementById('editAlunoId').value = aluno.id;
    document.getElementById('editName').value = aluno.user ? aluno.user.name : '';
    document.getElementById('editEmail').value = aluno.user ? aluno.user.email : '';
    document.getElementById('editTelefone').value = aluno.telefone;
    document.getElementById('editPeso').value = aluno.peso;
    document.getElementById('editAltura').value = aluno.altura;

    // Define a URL da ação do formulário com o ID do aluno
    const editForm = document.getElementById('editAlunoForm');
    editForm.action = `{{ url('alunos') }}/${aluno.id}`;
}


</script>

@endsection
