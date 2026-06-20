<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {

    // $roleCandidat = Role::where('slug', 'candidat')->first();

    // $candidat = User::where('role_id', $roleCandidat->id)->first();

    //     // 4. Ajout des documents pour le Candidat 1 (Paul Emmanuel)
    //     Document::create(
    //         [
    //             'user_id'   => '1',
    //             'title'     => 'CV Développeur Fullstack Laravel',
    //             'type'      => 'cv',
    //             'file_path' => 'documents/fake_cv_paul.pdf',
    //             'status'    => 'pending', // En attente
    //         ]
    //     );

    //     Document::create(
    //         [
    //             'user_id'   => '3',
    //             'title'     => 'Diplôme de Licence en Informatique',
    //             'type'      => 'diploma',
    //             'file_path' => 'documents/fake_licence_paul.pdf',
    //             'status'    => 'approved', // Déjà accepté
    //         ]
    //     );

    //     // 5. Ajout des documents pour le Candidat 2 (Jane Doe)
    //     Document::create(
    //         [
    //             'user_id'   => '4',
    //             'title'     => 'Lettre de motivation - Stage Tech',
    //             'type'      => 'cover_letter',
    //             'file_path' => 'documents/fake_lm_jane.pdf',
    //             'status'    => 'reviewed', // En cours de revue
    //         ]
    //     );
    // }

    public function run(): void
    {
        // 1. Récupérer le rôle candidat
        // Note : Assure-toi que le slug est bien 'candidate' ou 'candidat' selon ton RoleSeeder
        $roleCandidat = Role::where('slug', 'candidate')->first() ?? Role::where('slug', 'candidat')->first();

        if (!$roleCandidat) {
            $this->command->error("Le rôle candidat n'existe pas. Lance d'abord le RoleSeeder !");
            return;
        }

        // 2. Créer ou récupérer le Candidat 1 (Paul Emmanuel)
        $candidat1 = User::updateOrCreate(
            ['phone' => '+237677777777'],
            [
                'name'     => 'Paul Emmanuel',
                'password' => Hash::make('password123'),
                'role_id'  => $roleCandidat->id,
            ]
        );

        // 3. Créer ou récupérer le Candidat 2 (Jane Doe)
        $candidat2 = User::updateOrCreate(
            ['phone' => '+237699999999'],
            [
                'name'     => 'Jane Doe',
                'password' => Hash::make('password123'),
                'role_id'  => $roleCandidat->id,
            ]
        );

        // 4. Ajout des documents pour le Candidat 1 (Paul Emmanuel)
        Document::create([
            'user_id'   => $candidat1->id, // <-- ID Dynamique de Paul
            'title'     => 'CV Développeur Fullstack Laravel',
            'type'      => 'cv',
            'file_path' => 'documents/fake_cv_paul.pdf',
            'status'    => 'pending',
        ]);

        Document::create([
            'user_id'   => $candidat1->id, // <-- ID Dynamique de Paul
            'title'     => 'Diplôme de Licence en Informatique',
            'type'      => 'diploma',
            'file_path' => 'documents/fake_licence_paul.pdf',
            'status'    => 'approved', // 🛠️ Correction : 'accepted' au lieu de 'approved'
        ]);

        // 5. Ajout des documents pour le Candidat 2 (Jane Doe)
        Document::create([
            'user_id'   => $candidat2->id, // <-- ID Dynamique de Jane
            'title'     => 'Lettre de motivation - Stage Tech',
            'type'      => 'cover_letter',
            'file_path' => 'documents/fake_lm_jane.pdf',
            'status'    => 'reviewed',
        ]);
    }
}
