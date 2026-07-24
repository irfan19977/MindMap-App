<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create base admin user (Irfan)
        User::firstOrCreate(
            ['email' => 'irfanadiprasetyo27@gmail.com'],
            [
                'name'      => 'Irfan Adi',
                'password'  => bcrypt('password'),
                'user_type' => 'admin',
            ]
        );

        $this->call([
            RoleAndUserSeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
            MateriSeeder::class,
            BahasaIndonesiaSdContentSeeder::class,
            MindmapSeeder::class,
            BahasaIndonesiaSdClassSeeder::class,
        ]);
    }
}
