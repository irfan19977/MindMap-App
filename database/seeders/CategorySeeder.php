<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'name' => 'Bahasa Indonesia',
                'slug' => 'bahasa-indonesia',
                'description' => 'Pelajaran bahasa Indonesia untuk jenjang sekolah dasar',
                'is_featured' => true,
                'admin_email' => 'admin@gmail.com',
            ],
        ];

        foreach ($subjects as $subject) {
            $admin = User::where('email', $subject['admin_email'])->first();

            Category::updateOrCreate(
                ['slug' => $subject['slug']],
                [
                    'name' => $subject['name'],
                    'description' => $subject['description'],
                    'status' => 'publish',
                    'is_featured' => $subject['is_featured'],
                    'created_by' => $admin?->id,
                ]
            );
        }
    }
}
