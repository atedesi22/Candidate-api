<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidatRole = Role::where('slug', 'candidat')->first();

        // Récupérer le rôle admin
        $adminRole = Role::where('slug', 'admin')->first();

        User::create([
            'name' => "Emmanuel Bohole",
            'phone' => "+237600000000",
            'password' => Hash::make('password123'),
            'role_id' => $candidatRole->id,
        ]);

        User::create([
            'name' => 'Super Admin NexCandidate',
            'phone' => '+237611111111',
            'password' => Hash::make('adminpassword'),
            'role_id' => $adminRole->id,
        ]);

        // // 2. Création du Candidat 1
        // User::create(
        //     [   'phone' => '+237677777777',
        //         'name'     => 'Paul Emmanuel',
        //         'password' => Hash::make('password123'),
        //         'role_id'  => $candidatRole->id,
        //     ]
        // );

        // // 3. Création du Candidat 2
        // User::create(
        //     [   'phone' => '+237699999999',
        //         'name'     => 'Jane Doe',
        //         'password' => Hash::make('password123'),
        //         'role_id'  => $candidatRole->id,
        //     ]
        // );
    }
}


// {
//     "phone": "+237611111111",
//     "password": "adminpassword"
// }

// {
//     "phone": "+237600000000",
//     "password": "password123"
// }
