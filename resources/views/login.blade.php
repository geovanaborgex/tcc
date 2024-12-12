<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>webgym</title>
    
  <link rel="stylesheet" type="text/css" href="{{ url('assets/login/style.css')}}" />
  
</head>
<body>
    
<body>
    <div class="container" id="container">

        <!-- form de cadastro-->
        <div class="form-container sign-up">
            <form action="{{ route('cadastro') }}" method="POST">
            @csrf
                <h1>Crie sua conta</h1><br>
                <input type="email" id="email" placeholder="Email" name="email" required>
                <input type="password" id="password" placeholder="Senha" name="password" required>
                <input type="text" id="name" placeholder="Nome" name="name" required>

                <div style="display: flex; gap: 20px;">
                <label for="tipo">Tipo:</label><br><br>
                <input type="radio" id="aluno" name="tipo" value="A" required>
                <label for="aluno">Aluno</label><br>
                <input type="radio" id="profissional" name="tipo" value="P" required>
                <label for="profissional">Profissional</label><br><br>

            </div>
            <button type="submit">Cadastrar</button>
            </form>
        </div>

        <!-- form de login -->
        <div class="form-container sign-in">
        <form action="{{ route('logar') }}" method="POST">
            @csrf
            <h1>Entrar</h1><br>
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Senha" class="form-control" required>
            </div>
            <a href="{{ route('password.request') }}">Esqueceu a senha?</a>

            <button type="submit">Login</button>
        </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bem vindo a Webgym!</h1><br>
                    <center><img src="{{url ('assets/images/logo.png')}}" alt="">
                    </center>
                    <button class="hidden" id="login">Login</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Bem vindo a Webgym!</h1><br>
                    <center><img src="{{url ('assets/images/logo.png')}}" alt="">
                    </center>
                    <button class="hidden" id="register">Cadastro</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');

    registerBtn.addEventListener('click', () => {
        container.classList.add("active");
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove("active");
    });</script>

</body>
</html>

