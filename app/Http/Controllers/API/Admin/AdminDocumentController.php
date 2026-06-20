<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class AdminDocumentController extends Controller
{
    /**
     * Consulter la liste complète de tous les dossiers/documents envoyés.
     */

    public function index()
    {
        // On récupère tous les documents avec les infos du candidat (user) associé
        $documents = Document::with('user')->orderBy('created_at', 'desc')->get();

            // $documents = Document::all();

        return response()->json([
            'message' => 'Liste de tous les documents récupérée avec succès.',
            'documents' => $documents
        ], 200);
    }

    /**
     * Consulter un dossier spécifique.
     */
    public function show($id)
    {
        $documents = Document::with('user')->find($id);

        if (!$documents) {
            return response()->json([
                'message' => 'Document introuvable. '
            ], 404);
        }

        return response()->json([
            'document' => $documents
        ], 200);
    }

    /**
     * Modifier le statut d'un document (accepté, rejeté, etc.).
     */
    public function updatedStatus(Request $request, $id)
    {
        $document = Document::find($id);

        if (!$document) {
            # code...
            return response()->json([
                'message' => 'Document introuvable'
            ], 404);
        }

        // Validation du statut envoyé
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:pending,accepted,reviewed,rejected',
        ]);

        if ($validator->fails()) {
            # code...
            return response()->json([
            'message' => 'Validation échouée',
            'errors' => $validator->errors()
            ], 422);
        }

        // Mise à jour du statut
        $document->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Statut du document mis à jour avec succès.',
            'document' => $document
        ], 200);
    }
}
