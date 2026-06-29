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
        // Mapping: kategori -> email teacher yang mengajar
        $subjects = [
            [
                'name' => 'Matematika',
                'slug' => 'matematika',
                'description' => 'Pelajaran matematika untuk semua jenjang pendidikan',
                'is_featured' => true,
                'teacher_email' => 'ahmad.fauzi@example.com',
            ],
            [
                'name' => 'Bahasa Indonesia',
                'slug' => 'bahasa-indonesia',
                'description' => 'Pelajaran bahasa Indonesia untuk semua jenjang pendidikan',
                'is_featured' => true,
                'teacher_email' => 'eko.prasetyo@example.com',
            ],
            [
                'name' => 'IPA',
                'slug' => 'ipa',
                'description' => 'Ilmu Pengetahuan Alam untuk semua jenjang pendidikan',
                'is_featured' => true,
                'teacher_email' => 'sarah.wijaya@example.com',
            ],
            [
                'name' => 'IPS',
                'slug' => 'ips',
                'description' => 'Ilmu Pengetahuan Sosial untuk semua jenjang pendidikan',
                'is_featured' => false,
                'teacher_email' => 'rina.pratiwi@example.com',
            ],
            [
                'name' => 'Bahasa Inggris',
                'slug' => 'bahasa-inggris',
                'description' => 'Pelajaran bahasa Inggris untuk semua jenjang pendidikan',
                'is_featured' => true,
                'teacher_email' => 'budi.santoso@example.com',
            ],
        ];

        foreach ($subjects as $subject) {
            $teacher = User::where('email', $subject['teacher_email'])->first();

            Category::firstOrCreate(
                ['slug' => $subject['slug']],
                [
                    'name' => $subject['name'],
                    'description' => $subject['description'],
                    'status' => 'publish',
                    'is_featured' => $subject['is_featured'],
                    'created_by' => $teacher?->id,
                ]
            );
        }
    }
}
