@extends('layouts.main')

@section('content')

<style>
    body {
        background: linear-gradient(to right, rgba(84, 29, 139, 0.780), rgba(84, 29, 140, 1)), url('https://invexo.com.br/blog/wp-content/uploads/2022/12/smartfit-academias-na-barra-da-tijuca-rio-de-janeiro-1024x576.jpg');
        margin: 0;
        padding: 0;
    }
    .profile-container {
        max-width: 700px;
        margin: 20px auto;
        background-color: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 40%;
        margin: 0 auto 20px;
        overflow: hidden;
        border: 6px solid #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .profile-picture img {
        width: 100%;
        height: auto;
    }

    .profile-info h2 {
        margin-bottom: 10px;
        color: #663399;
    }
    .profile-info p {
        margin-bottom: 5px;
        color: #663399;
    }
    .profile-info .label {
        font-weight: bold;
        color: #f39c12;
    }
    .transparent-button {
        color: black;
        background-color: white; 
        border: white; 
    }

    .add-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 30px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-left:35%;
        font-size: 18px;
        
    }

    i {
        cursor: pointer;
        color: rgba(84, 29, 139, 1);
    }
    .input-group-text {
        background-color: #f0f0f0;
        border-right: none;
    }
    .form-control {
        border-left: none;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group i {
        margin-right: 10px;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<section class="contact_section layout_padding">
    <div class="container">
        <div class="profile-container">
            <div class="profile-info">
                <div class="container">
                    @if (Auth::check())
                        <form action="{{ route('editarPerfil') }}" method="POST">
                            @csrf

                            <!-- Campo de Nome -->
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                            <i class="bi bi-person-fill"></i> <!-- Ícone de nome -->
                                       
                                    </div>
                                    <input type="text" id="nome" name="nome" placeholder="Digite seu nome" value="{{ old('nome', Auth::user()->name) }}" required>
                                </div>
                            </div>

                            <!-- Campo de Email -->
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                            <i class="bi bi-envelope-fill"></i> <!-- Ícone de email -->
                                    </div>
                                    <input type="email" id="email" name="email" placeholder="Digite seu email" value="{{ old('email', Auth::user()->email) }}" required>
                                </div>
                            </div>

                            <!-- Campo de Nova Senha -->
                            <div class="form-group">
                                <label for="senha">Senha:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                            <i class="bi bi-lock-fill"></i> <!-- Ícone de senha -->
                                    </div>
                                    <input type="password" id="senha" name="senha" placeholder="Digite sua nova senha">
                                    <i class="fas fa-eye" id="mostrar-senha"></i> <!-- Ícone de olho para mostrar senha -->
                                </div>
                            </div>

                            <!-- Campos Adicionais para Profissionais -->
                            @if (Auth::user()->tipo == 'P')
                                <div class="form-group">
                                    <label for="formacao">Formação:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                                <i class="bi bi-journal-bookmark-fill"></i> <!-- Ícone de diploma -->
                                                <input type="text" id="formacao" name="formacao" placeholder="Digite sua formação" value="{{ old('formacao', $profissional->formacao ?? 'Currículo') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="biografia">Biografia:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <i class="bi bi-person-lines-fill"></i> <!-- Ícone de biografia -->
                                        </div>
                                        <input type="text" id="biografia" name="biografia" placeholder="Escreva sua biografia" value="{{ old('biografia', $profissional->biografia ?? 'Algo sei lá qualquer coisa') }}">
                                    </div>
                                </div>
                            @endif

                            @if (Auth::user()->tipo == 'A')
                                <div class="form-group">
                                    <label for="telefone">Telefone:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                                <i class="bi bi-telephone-fill"></i> <!-- Ícone de telefone -->
                                        </div>
                                        <input type="text" id="telefone" name="telefone" placeholder="Seu telefone" value="{{ old('telefone', $aluno->telefone ?? '') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="peso">Peso (kg):</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <i class="fas fa-weight-scale"></i>
                                        </div>
                                        <input type="number" id="peso" name="peso" placeholder="Seu peso" value="{{ old('peso', $aluno->peso ?? '') }}" step="0.2">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="altura">Altura (cm):</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <i class="fas fa-ruler-vertical"></i>                                        </div>
                                        <input type="number" id="altura" name="altura" placeholder="Sua altura" value="{{ old('altura', $aluno->altura ?? '') }}" step="0.2">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="biografia">Biografia:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                                <i class="bi bi-person-lines-fill"></i> <!-- Ícone de biografia -->
                                        </div>
                                        <input type="text" id="biografia" name="biografia" placeholder="Sua biografia" value="{{ old('biografia', $aluno->biografia ?? '') }}">
                                    </div>
                                </div>
                            @endif

                            <button type="submit" class="add-button">Salvar Perfil</button>
                        </form>
                    @else
                        <p>Usuário não autenticado. Por favor, faça login.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>

<script>
    document.getElementById('mostrar-senha').addEventListener('click', function() {
        var senhaField = document.getElementById('senha');
        var icon = this.querySelector('i');

        // Alternar o tipo do campo entre 'password' e 'text'
        if (senhaField.type === 'password') {
            senhaField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');  // Ícone de olho cortado para ocultar a senha
        } else {
            senhaField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');  // Ícone de olho para mostrar a senha
        }
    });
</script>

@endsection
