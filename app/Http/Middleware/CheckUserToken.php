<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		if (!$request->session()->has('userToken')) {
            // Si l'apiKey n'est pas présente, rediriger l'utilisateur vers la page de connexion
            return redirect()->route('admin.login')->withErrors(['message' => 'Votre session a expiré. Veuillez vous reconnecter.']);
        }

        // Si l'apiKey est présente, autoriser la requête
        return $next($request);
    }
}
