<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarTipoUsuario
{
    public function handle(Request $request, Closure $next, $tipo)
    {
        $usuario = Auth::user();

        // Verifica se o usuário está autenticado e se o tipo corresponde
        if ($usuario && $usuario->tipo == $tipo) {
            return $next($request);
        }

        // Caso contrário, você pode redirecionar ou exibir uma mensagem de erro
        return redirect('/');  // Exemplo de redirecionamento, ajuste conforme necessário
    }
}
