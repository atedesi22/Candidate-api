<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Gérer la requête entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  Le rôle requis (ex: 'admin' ou 'candidate')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Vérifier si l'utilisateur est authentifié
        if(!request->user()){
            return response()->json([
                'message' => 'Utilisateur non authentifié.'
            ], 401);
        }

        // 2. Vérifier si le slug du rôle de l'utilisateur correspond au rôle requis.
        if ($request->user()->role->slug !== $role) {
            return response()->json([
                'message' => 'Accès interdit. Vous n\'avez pas les permissions nécessaires.'
            ], 403);
        }
        return $next($request);
    }
}
