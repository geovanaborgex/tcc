<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>

    <style>
        /* Certifique-se de importar a fonte Montserrat */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');

        /* Estilo geral do formulário */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-color: #f3cb5c;
            background: linear-gradient(to right, #691bc2e6, #f3cb5c);
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
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <h1>Recuperar Senha</h1>
            <p>Digite seu email abaixo para receber o link de redefinição de senha.</p>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="Seu email" class="form-control" required autofocus>
            </div>

            <button type="submit" class="submit-btn">Enviar Link</button>

            @if (session('status'))
                <p class="status-message">Enviamos por e-mail seu link de redefinição de senha.</p>
            @endif
        </form>
    </div>

</body>
</html>
