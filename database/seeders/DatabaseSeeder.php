<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\DocumentSeeder;
use Database\Seeders\Roleseeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            Roleseeder::class,
            UserSeeder::class,
            DocumentSeeder::class,
        ]);

        $path = database_path('migrations/oauth_clients_202606181552.sql');
        DB::unprepared(file_get_contents($path));
        $this->command->info('OAuth clients table seeded!');
    }
}
