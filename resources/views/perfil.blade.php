@extends('layouts.main')

@section('content')

  
  <style>
    body {
        background: linear-gradient(to right, rgba(84, 29, 139, 0.780), rgba(84, 29, 140, 1)), url('https://invexo.com.br/blog/wp-content/uploads/2022/12/smartfit-academias-na-barra-da-tijuca-rio-de-janeiro-1024x576.jpg');
        margin: 0;
        padding: 0;
    }
    .profile-container {
        max-width: 600px;
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

    i{
      cursor: pointer;
      color:  rgba(84, 29, 139, 1);
    }
  </style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome" value="{{ old('nome', Auth::user()->name) }}" required>
            </div>

            <!-- Campo de Email -->
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Digite seu email" value="{{ old('email', Auth::user()->email) }}" required>
            </div>

            <!-- Campo de Nova Senha -->
            <div class="form-group">
                <label for="senha">Nova Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua nova senha">
                <i class="bi bi-eye-slash" onclick="togglePassword()"></i>
            </div>

            <!-- Campos Adicionais para Profissionais -->
            @if (Auth::user()->tipo == 'P')
                <div class="form-group">
                    <label for="formacao">Formação:</label>
                    <input type="text" id="formacao" name="formacao" placeholder="Sua formação" value="{{ old('formacao', $profissional->formacao ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="biografia">Biografia:</label>
                    <textarea id="biografia" name="biografia" placeholder="Sua biografia">{{ old('biografia', $profissional->biografia ?? '') }}</textarea>
                </div>
            @endif

            <!-- Campos Adicionais para Alunos -->
            @if (Auth::user()->tipo == 'A')
                <div class="form-group">
                    <label for="telefone">Telefone:</label>
                    <input type="text" id="telefone" name="telefone" placeholder="Seu telefone" value="{{ old('telefone', $aluno->telefone ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="peso">Peso (kg):</label>
                    <input type="number" id="peso" name="peso" placeholder="Seu peso" value="{{ old('peso', $aluno->peso ?? '') }}" step="0.2">
                </div>
                <div class="form-group">
                    <label for="altura">Altura (cm):</label>
                    <input type="number" id="altura" name="altura" placeholder="Sua altura" value="{{ old('altura', $aluno->altura ?? '') }}" step="0.2">
                </div>
                <div class="form-group">
                    <label for="biografia">Biografia: </label>
                    <textarea id="biografia" name="biografia" placeholder="Sua biografia">{{ old('biografia', $aluno->biografia ?? '') }}</textarea>
                </div>
            @endif


            <!-- Botão Salvar -->
            <button type="submit" style="background-color: #f8bc1a; color: white; padding: 10px 20px; border: none; border-radius: 10px; cursor: pointer;">Salvar Perfil</button>
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
  // Seleciona o <a> que contém a imagem de perfil
const ftPerfil = document.getElementById('ftPerfil');
const ftPerfilImg = document.getElementById('ftPerfilImg'); // A imagem dentro do <a>

// Variável global para armazenar a imagem selecionada
let currentImageSrc = foto; 

    function togglePassword() {
    const senhaInput = document.getElementById('senha');
    const tipo = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password';
    senhaInput.setAttribute('type', tipo);
}
  </script>
@endsection