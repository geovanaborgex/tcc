<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>

    <style>
        /* Certifique-se de importar a fonte Montserrat */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
        @import url('https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css');

        /* Estilo geral do formulário */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-color: #f3cb5c;
            background: linear-gradient(to right, #691bc2e6, #f3cb5c); /* Gradiente entre roxo e amarelo */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .form-container.reset-password {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 30px;
        }

        .form-container.reset-password h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #691bc2e6; /* Cor roxa para o título */
        }

        .form-container.reset-password p {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .form-group {
            width: 100%;
            margin-bottom: 20px;
            position: relative; /* Para posicionar o ícone ao lado do input */
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #691bc2e6; /* Cor roxa ao focar no campo */
            outline: none;
        }

        .form-group i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #691bc2e6; /* Cor roxa para o ícone */
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #691bc2e6; /* Cor roxa para o botão */
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #f3cb5c; /* Cor amarela ao passar o mouse */
        }

        .status-message {
            font-size: 14px;
            color: #691bc2e6; /* Cor roxa para mensagens de status */
            margin-top: 20px;
        }
    </style>

</head>
<body>

    <div class="form-container reset-password">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <h1>Redefinir Senha</h1>
            <p>Digite seu email e a nova senha abaixo para redefinir sua senha.</p>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="Seu email" class="form-control" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Nova Senha</label>
                <input id="password" type="password" name="password" placeholder="Nova senha" class="form-control" required>
                <i class="bi bi-eye-slash-fill" onclick="togglePassword()"></i> <!-- Ícone de olho -->
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirme a Nova Senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirme a nova senha" class="form-control" required>
                
            </div>

            <button type="submit" class="submit-btn">Redefinir Senha</button>

            @if (session('status'))
                <p class="status-message">A senha foi redefinida com sucesso!</p>
            @endif
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Altera o ícone
            const icon = document.querySelector('.form-group i');
            if (type === 'password') {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye');
            }
        }
    </script>

</body>
</html>
