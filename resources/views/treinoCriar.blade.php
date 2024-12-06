@extends('layouts.main')

@section('content')

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>


<style>
    /* Seus estilos */
    .add-button {
        position: absolute;
        bottom: 20px;
        right: 50px;
        padding: 10px 20px;
        background-color: #691bc2e6;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    
    .modal {
        display: flex;
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

    /* Modal content */
    .modal-content {
        width: 90%;
        max-width: 600px;
        max-height: 80%; 
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        overflow-y: auto; /* Adiciona rolagem quando o conteúdo ultrapassa o limite */
    }

    .close {
        cursor: pointer;
        font-size: 1.5em;
        font-weight: bold;
        color: #333;
        float: right;
    }

    #treinosContainer {
        max-height: 60vh; 
        overflow-y: auto; 
    }


    table.table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table.table th,
    table.table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    table.table th {
        background-color: #691bc2e6;
        font-weight: bold;
    }

    .close-btn {
        float: right;
        font-size: 24px;
        cursor: pointer;
    }

    .modal-body form {
        display: flex;
        flex-direction: column;
    }

    .modal-body label,
    .modal-body input {
        margin-bottom: 10px;
    }

    .modal-body input {
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }


    .modal-footer {
        display: flex;
        justify-content: flex-end;
    }

    .modal-footer button {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #addExercicioBtn {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #addExercicioBtn:hover {
        background-color: darkorange;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th, .table td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #691bc2e6;
        color: white;
    }
    .add-buttonn {
        background-color: white;
        color: #691bc2e6;
        padding: 5px 10px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 14px;
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
                       <center>
                            <h1>Criação de treino</h1><br>
                            <h3> Aluno: {{ $nomeAluno }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             Profissional: {{ $nomeProf }}</h3>
                            <button type="button" id="verTreinosBtn" class="add-button" onclick="abrirModal()">Vizualizar Treinos</button>
                        </center>
                    </div>
                </div>
                <!--Formulário de criaçao de treino -->
                <form id="treinoForm" method="POST" action="{{ route('treinos.store') }}">
                    @csrf
                    <center>
                    <h3><label for="categoria" style="color: #691bc2e6;">Categoria do Treino: </label></h3>
                    <input type="text" id="categoria" name="categoria" required></center>

                    <input type="hidden" id="contrato_id" name="contrato_id" value="{{ $contrato->id }}">


                    <div id="exerciciosList">
                        <table class="table" id="exerciciosTable">
                            <thead>
                                <tr>
                                    <th>Nome do Exercício</th>
                                    <th>Séries</th>
                                    <th>Repetições</th>
                                    <th>Carga (kg)</th>
                                    <th>Observação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>

                    <button type="button" id="addExercicioBtn">Adicionar exercício</button>
                    <div class="modal-footer">
                        <button type="submit">Salvar Treino</button>
                    </div>
                </form>

      <!-- Modal de adicionar exercício -->
<div id="addExercicioModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-btn" id="closeExercicioModal">&times;</span>
        <h3>Adicionar Exercício</h3>

        <label for="nomeExercicio">Nome do Exercício</label>
        <input type="text" id="nomeExercicio" name="nome_exercicio">
        <span id="nomeExercicioError" class="error-message" style="color: red; display: none;">Por favor, preencha este campo</span>

        <label for="series">Séries</label>
        <input type="number" id="series" name="series">
        <span id="seriesError" class="error-message" style="color: red; display: none;">Por favor, preencha este campo</span>

        <label for="repeticoes">Repetições</label>
        <input type="number" id="repeticoes" name="repeticoes">
        <span id="repeticoesError" class="error-message" style="color: red; display: none;">Por favor, preencha este campo</span>

        <label for="carga">Carga (kg)</label>
        <input type="number" id="carga" name="carga">
        <span id="cargaError" class="error-message" style="color: red; display: none;">Por favor, preencha este campo</span>

        <label for="observacao">Observação</label>
        <input type="text" id="observacao" name="observacao">
        <span id="observacaoError" class="error-message" style="color: red; display: none;">Por favor, preencha este campo</span>

        <div class="modal-footer">
            <button type="button" id="salvarExercicioBtn">Salvar Exercício</button>
            <button type="button" id="addOutroExercicioBtn">Adicionar Mais Exercícios</button>
        </div>
    </div>
</div>



        <!-- Modal de ver treinos-->
        <div id="treinosModal" class="modal" style="display:none;">
        <div style="border-radius: 10px; background-color:white; padding: 20px; ">
            <span class="close" onclick="fecharModal()">&times;</span>
           <center> <h2>Treinos de {{ $nomeAluno }}</h2></center><br>
            <div id="treinosContainer"></div>
        </div>
        </div>

        <!-- Modal de editar treinos-->
        <div id="editarTreinoModal" class="modal" style="display: none;">
            <div class="modal-content">
                <h3>Editar Treino</h3>
                <label for="category">Categoria:</label>
                <input type="text" id="category" name="category" required><br>
                <div id="exerciciosContainer"></div>
                <button onclick="adicionarExercicio()">Adicionar Exercício</button>
                <button onclick="salvarTreino()">Salvar</button>
                <button onclick="fecharEditarModal()">Cancelar</button>
                </div>
            </div>
        </div>

            </div>
        </div>
    </div>
</div>


<meta name="csrf-token" content="{{ csrf_token() }}">

               <!-- -----------------modal de inserir exercícios e criar treino------------------- -->
<script>

let contadorExercicio = 0;

// Abrir modal de adicionar exercício
document.getElementById('addExercicioBtn').addEventListener('click', function() {
    document.getElementById('addExercicioModal').style.display = 'flex';
});

// Fechar modal
document.getElementById('closeExercicioModal').addEventListener('click', function() {
    document.getElementById('addExercicioModal').style.display = 'none';
});

// Adicionar exercício ao formulário e à tabela
// Adicionar exercício ao formulário e à tabela
document.getElementById('salvarExercicioBtn').addEventListener('click', function() {
    // Obter valores dos campos de exercício
    let nome = document.getElementById('nomeExercicio').value;
    let series = document.getElementById('series').value;
    let repeticoes = document.getElementById('repeticoes').value;
    let carga = document.getElementById('carga').value;
    let observacao = document.getElementById('observacao').value;

    // Limpar mensagens de erro anteriores
    document.getElementById('nomeExercicioError').style.display = 'none';
    document.getElementById('seriesError').style.display = 'none';
    document.getElementById('repeticoesError').style.display = 'none';
    document.getElementById('cargaError').style.display = 'none';
    document.getElementById('observacaoError').style.display = 'none';

    let camposValidos = true;

    // Verificar se todos os campos foram preenchidos e exibir mensagens de erro
    if (!nome) {
        document.getElementById('nomeExercicioError').style.display = 'inline';
        camposValidos = false;
    }
    if (!series) {
        document.getElementById('seriesError').style.display = 'inline';
        camposValidos = false;
    }
    if (!repeticoes) {
        document.getElementById('repeticoesError').style.display = 'inline';
        camposValidos = false;
    }
    if (!carga) {
        document.getElementById('cargaError').style.display = 'inline';
        camposValidos = false;
    }
    if (!observacao) {
        document.getElementById('observacaoError').style.display = 'inline';
        camposValidos = false;
    }

    // Se algum campo estiver vazio, não salvar o exercício
    if (!camposValidos) {
        return; // Impede que o exercício seja adicionado
    }

    // Criar novo item de exercício na tabela
    const exercicioHTML = `
        <tr>
            <td>${nome}</td>
            <td>${series}</td>
            <td>${repeticoes}</td>
            <td>${carga}</td>
            <td>${observacao}</td>
            <td><button class="deletar-btn" style="border:none; background-color: transparent;">🗑️</button></td>
            
            <input type="hidden" name="exercicios[${contadorExercicio}][nome]" value="${nome}">
            <input type="hidden" name="exercicios[${contadorExercicio}][series]" value="${series}">
            <input type="hidden" name="exercicios[${contadorExercicio}][repeticoes]" value="${repeticoes}">
            <input type="hidden" name="exercicios[${contadorExercicio}][carga]" value="${carga}">
            <input type="hidden" name="exercicios[${contadorExercicio}][observacao]" value="${observacao}">
        </tr>
    `;

    document.querySelector('#exerciciosTable tbody').insertAdjacentHTML('beforeend', exercicioHTML);

    // Incrementar o contador de exercícios
    contadorExercicio++;

    // Fechar modal
    document.getElementById('addExercicioModal').style.display = 'none';

    // Limpar campos do modal
    document.getElementById('nomeExercicio').value = '';
    document.getElementById('series').value = '';
    document.getElementById('repeticoes').value = '';
    document.getElementById('carga').value = '';
    document.getElementById('observacao').value = '';
});


// Continuar adicionando mais exercícios
document.getElementById('addOutroExercicioBtn').addEventListener('click', function() {
    document.getElementById('salvarExercicioBtn').click(); // Salva o exercício atual
    document.getElementById('addExercicioModal').style.display = 'flex'; // Mantém o modal aberto
});

// Deletar exercício ao clicar no botão de exclusão
document.querySelector('#exerciciosTable').addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('deletar-btn')) {
        // Encontrar a linha da tabela onde o botão foi clicado
        const linhaExercicio = event.target.closest('tr');
        if (linhaExercicio) {
            linhaExercicio.remove(); // Remove a linha da tabela
        }
    }
});

// Enviar formulário
document.getElementById('treinoForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Evitar o envio normal do formulário

    let formData = new FormData(this); // Capturar os dados do formulário

    fetch("{{ route('treinos.store') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            // Exibir o alerta SweetAlert2
            Swal.fire({
                title: 'Sucesso!',
                text: 'Treino adicionado com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Recarregar a página ou redirecionar após o alerta
                window.location.reload();
            });
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        Swal.fire({
            title: 'Erro!',
            text: 'Ocorreu um erro ao adicionar o treino.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
});

</script>

                <!-- -----------------modal de ver treinos------------------- -->
<script>

    document.getElementById('verTreinosBtn').addEventListener('click', function() {
        abrirModal();
    });

    function abrirModal() {
        var contratoId = {{ $contrato->id }}; 
        var url = "{{ route('treinos.show', ':id') }}".replace(':id', contratoId);

        fetch(url)
            .then(response => response.json())
            .then(treinos => {
                let treinosHTML = '';
                
                if (treinos.length === 0) {
                    treinosHTML = '<p>Não há treinos registrados para este aluno.</p>';
                } else {
                    treinos.forEach(treino => {
                        treinosHTML += `
                            <div class="treino">
                                <h4>Categoria do Treino: ${treino.categoria}</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nome do Exercício</th>
                                            <th>Séries</th>
                                            <th>Repetições</th>
                                            <th>Carga (kg)</th>
                                            <th>Observação</th>
                                            <th>
                                                <button class="add-buttonn"  data-treino-id="${treino.id}">🗑️ Deletar</button>
                                                <button class="add-buttonn"  data-treino-id="${treino.id}">✏️ Editar</button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${treino.exercicios.map(exercicio => `
                                            <tr>
                                                <td>${exercicio.nome}</td>
                                                <td>${exercicio.series}</td>
                                                <td>${exercicio.repeticoes}</td>
                                                <td>${exercicio.carga}</td>
                                                <td>${exercicio.observacao}</td>
                                                
                                            </tr>
                                        `).join('')}
                                     
                                    </tbody>
                                </table>
                            </div>
                        `;
                    });
                }
                 document.getElementById('treinosContainer').innerHTML = treinosHTML;
                document.getElementById('treinosModal').style.display = 'flex';
            })
            .catch(error => {
                console.error('Erro ao carregar treinos:', error);
            });
    }


    //        AÇÃO: Excluir 
    document.addEventListener('DOMContentLoaded', function() {
    // Escuta cliques em toda a tabela para capturar o evento de deletar
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('add-buttonn') && event.target.textContent.includes("🗑️")) {
            const treinoId = event.target.getAttribute('data-treino-id');

            if (treinoId && confirm('Tem certeza que deseja deletar este treino?')) {
                fetch(`/treinos/${treinoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => {
                    if (response.ok) {
                        alert('Treino deletado com sucesso!');
                    } else {
                        alert('Erro ao deletar treino.');
                    }
                })
                .catch(error => console.error('Erro:', error));
            }
        }
    });
});



    //       AÇÃO: Editar
    document.addEventListener('click', function(event) {
    if (event.target.classList.contains('add-buttonn') && event.target.textContent.includes("✏️")) {
        const treinoId = event.target.getAttribute('data-treino-id');

        // Armazene o ID do treino em um campo oculto ou diretamente no modal
        document.getElementById('editarTreinoModal').setAttribute('data-treino-id', treinoId);

        fetch(`/treinos/${treinoId}/edit`)
            .then(response => response.json())
            .then(treino => {
                const categoriaInput = document.getElementById('category');
                const exerciciosContainer = document.getElementById('exerciciosContainer');

                if (!categoriaInput || !exerciciosContainer) {
                    console.error('Elementos do DOM para edição não encontrados.');
                    return;
                }

                categoriaInput.value = treino.categoria;
                exerciciosContainer.innerHTML = '';

                treino.exercicios.forEach((exercicio, index) => {
                    exerciciosContainer.innerHTML += `
                        <div class="exercicio">
                            <label for="nome_${index}">Nome:</label>
                            <input type="text" id="nome_${index}" name="exercicios[${index}][nome]" value="${exercicio.nome}" required>
                            
                            <label for="series_${index}">Séries:</label>
                            <input type="number" id="series_${index}" name="exercicios[${index}][series]" value="${exercicio.series}" required>
                            
                            <label for="repeticoes_${index}">Repetições:</label>
                            <input type="number" id="repeticoes_${index}" name="exercicios[${index}][repeticoes]" value="${exercicio.repeticoes}" required>
                            
                            <label for="carga_${index}">Carga:</label>
                            <input type="number" id="carga_${index}" name="exercicios[${index}][carga]" value="${exercicio.carga}">
                            
                            <label for="observacao_${index}">Observação:</label>
                            <input type="text" id="observacao_${index}" name="exercicios[${index}][observacao]" value="${exercicio.observacao}">
                        </div>
                    `;
                });

                // Exibir o modal
                document.getElementById('editarTreinoModal').style.display = 'flex';
            })
            .catch(error => console.error('Erro ao carregar treino para edição:', error));
    }
});

    function fecharEditarModal() {
        document.getElementById('editarTreinoModal').style.display = 'none';
    }

    function salvarTreino() {
    const treinoId = document.getElementById('editarTreinoModal').getAttribute('data-treino-id'); // ID correto
    const category = document.getElementById('category').value;
    const exercicios = [...document.querySelectorAll('#exerciciosContainer .exercicio')].map((div, index) => ({
        nome: div.querySelector(`#nome_${index}`).value,
        series: div.querySelector(`#series_${index}`).value,
        repeticoes: div.querySelector(`#repeticoes_${index}`).value,
        carga: div.querySelector(`#carga_${index}`).value,
        observacao: div.querySelector(`#observacao_${index}`).value,
    }));

    fetch(`/treinos/${treinoId}`, {
    method: 'PUT',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
    },
    body: JSON.stringify({ category, exercicios }),
})
    .then(response => {
        if (!response.ok) {
            // Se a resposta não for "ok", lance um erro para o catch
            throw new Error('Erro na requisição');
        }
        return response.json(); // Parse da resposta JSON
    })
    .then(data => {
        console.log(data); // Log para verificar a estrutura da resposta
        if (data.status === 'success') { // Verifica "status" em vez de "success"
            Swal.fire({
                title: 'Sucesso!',
                text: data.message || 'Treino atualizado com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Atualizar a página ou a interface
                window.location.reload();
            });
        } else {
            Swal.fire({
                title: 'Erro!',
                text: data.message || 'Não foi possível atualizar o treino.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        Swal.fire({
            title: 'Erro!',
            text: 'Ocorreu um erro inesperado.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });

}


    function adicionarExercicio() {
    const exerciciosContainer = document.getElementById('exerciciosContainer');
    const index = exerciciosContainer.children.length;

    exerciciosContainer.innerHTML += `
        <div class="exercicio">
            <label for="nome_${index}">Nome:</label>
            <input type="text" id="nome_${index}" name="exercicios[${index}][nome]" required>
            
            <label for="series_${index}">Séries:</label>
            <input type="number" id="series_${index}" name="exercicios[${index}][series]" required>
            
            <label for="repeticoes_${index}">Repetições:</label>
            <input type="number" id="repeticoes_${index}" name="exercicios[${index}][repeticoes]" required>
            
            <label for="carga_${index}">Carga:</label>
            <input type="number" id="carga_${index}" name="exercicios[${index}][carga]">
            
            <label for="observacao_${index}">Observação:</label>
            <input type="text" id="observacao_${index}" name="exercicios[${index}][observacao]">
        </div>
    `;
}
   



//---fecha o modal de ver treinos---//
    function fecharModal() {
            document.getElementById('treinosModal').style.display = 'none';
        }
    

    document.querySelector('.close').addEventListener('click', fecharModal);
</script>

@endsection
