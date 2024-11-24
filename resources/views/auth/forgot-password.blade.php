<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <label for="email">Digite seu email</label>
    <input id="email" type="email" name="email" required autofocus>
    <button type="submit">Enviar link de redefinição</button>
</form>
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif
