<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Roleseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $roles = [
            [
                'slug' => 'admin', 
                'name' => 'Administrateur',
                'description' => 'Gestion globale de la plateforme et consultation de tous les dossiers.'
            ],

            [
                'slug' => 'candidat',
                'name' => 'Candidat',
                'description' => 'Utilisateur standard qui soumet ses dossiers et candidatures.'
            ],
            // ['slug' => 'manager', 'description' => 'Acteur futur qui pourra consulter les dossiers liés à ses offres.'],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
    }
}
