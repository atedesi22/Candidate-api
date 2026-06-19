<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    /**
     * Inscription d'un nouveau Candidat.
     */

    public function register(Request $request)
    {
        // 1. Validation des données entrantes
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json([
                'erros' => $validator->errors()
            ], 422);
        }

        // 2. Récupération automatique du rôle 'candidate'
        $candidateRole = Role::where('slug', 'candidat')->first();

        if (!$candidateRole) {
            return response()->json([
                'error' => 'Le rôle par défaut (candidat) n\'a pas été configuré veuiellez contacter l\'administrateur de la plateforme.'
            ], 500);
        }

        // 3. Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $candidateRole->id, // Associe automatiquement le rôle de candidat
        ]);

        // 4. Génération du token de session Passport
        $token = $user->createToken('CandidatToken')->accessToken;

        // 5. Réponse JSON avec les détails de l'utilisateur et le token
        return response()->json([
            'message' => 'Inscription réussie',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'role' => $candidateRole->name,
            ],
            'token' => $token
        ], 201);
    }

    /**
     * Connexion par numéro de téléphone.
     */
    public function login(Request $request)
    {
        // 1. Validation des données entrantes
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'erros' => $validator->errors()
            ], 422);
        }

        // 2. Vérification de l'existence de l'utilisateur avec son rôle
        $user = User::with('role')->where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Numéro de téléphone ou mot de passe incorrect.'
            ], 401);
        }

        // 3. Génération du token de session Passport
        $token = $user->createToken('CandidatToken')->accessToken;

        // 4. Réponse JSON avec les détails de l'utilisateur et le token
        return response()->json([
            'message' => 'Connexion réussie',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'role' => $user->role ? $user->role->slug : null,
            ],
            'token' => $token
        ], 200);
    }

    /**
     * Déconnexion de l'utilisateur (révocation du token).
     */
    public function logout(Request $request)
    {
        // Récupération du token Passport actif et révocation
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Déconnexion réussie'
        ], 200);
    }
}
