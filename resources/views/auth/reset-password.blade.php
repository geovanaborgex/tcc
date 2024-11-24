<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ request()->route('token') }}">
    <label for="email">Email</label>
    <input id="email" type="email" name="email" required autofocus>
    
    <label for="password">Nova senha</label>
    <input id="password" type="password" name="password" required>

    <label for="password_confirmation">Confirme a nova senha</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>

    <button type="submit">Redefinir senha</button>
</form>
