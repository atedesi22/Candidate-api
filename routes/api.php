<?php


use App\Http\Controllers\API\Admin\AdminDocumentController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\DocumentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Ici se trouvent toutes les routes de l'API de NexCandidate.
| Le guard par défaut utilisé par Passport est configuré via 'auth:api'.
|
*/

// ==========================================
// 🔓 ROUTES PUBLIQUES (Authentification)
// ==========================================

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ==========================================
// 🔒 ROUTES PROTÉGÉES (Authentifiées via Passport)
// ==========================================

Route::middleware('auth:api')->group(function() {

// Récupérer le profil de l'utilisateur connecté
    Route::get('/user', function (Request $request) {
        // On charge la relation 'role' pour savoir instantanément qui il est
        return response()->json([
            'user' => $request->user()
        ], 200);
    });

    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']);

    // --------------------------------------
    // 👤 ESPACE CANDIDAT (role: candidate)
    // --------------------------------------
    Route::middleware('role:candidat')->prefix('candidate')->group(function () {
        // Soumettre un nouveau document/dossier
        Route::post('/documents', [DocumentController::class,'store']);

        // Consulter ses propres documents soumis
        Route::get('/documents', [DocumentController::class,'index']);
    });

    // --------------------------------------
    // 🛡️ ESPACE ADMINISTRATEUR (role: admin)
    // --------------------------------------
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Consulter tous les documents soumis par les candidats
        Route::get('/documents', [AdminDocumentController::class,'index']);

        // Consulter un document spécifique par son ID
        Route::get('/documents/{id}', [AdminDocumentController::class,'show']);

        // Mettre à jour le statut d'un document (approuver ou rejeter)
        Route::put('/documents/{id}/status', [AdminDocumentController::class,'updateStatus']);
    });

});
