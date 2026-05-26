<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 5 Mata Pelajaran Utama
        $subjects = [
            [
                'name' => 'Matematika',
                'slug' => 'matematika',
                'description' => 'Pelajaran matematika untuk semua jenjang pendidikan',
                'is_featured' => true,
            ],
            [
                'name' => 'Bahasa Indonesia',
                'slug' => 'bahasa-indonesia',
                'description' => 'Pelajaran bahasa Indonesia untuk semua jenjang pendidikan',
                'is_featured' => true,
            ],
            [
                'name' => 'IPA',
                'slug' => 'ipa',
                'description' => 'Ilmu Pengetahuan Alam untuk semua jenjang pendidikan',
                'is_featured' => true,
            ],
            [
                'name' => 'IPS',
                'slug' => 'ips',
                'description' => 'Ilmu Pengetahuan Sosial untuk semua jenjang pendidikan',
                'is_featured' => false,
            ],
            [
                'name' => 'Bahasa Inggris',
                'slug' => 'bahasa-inggris',
                'description' => 'Pelajaran bahasa Inggris untuk semua jenjang pendidikan',
                'is_featured' => true,
            ],
        ];

        foreach ($subjects as $subject) {
            // Create main category
            Category::create([
                'name' => $subject['name'],
                'slug' => $subject['slug'],
                'description' => $subject['description'],
                'status' => 'publish',
                'is_featured' => $subject['is_featured'],
            ]);
        }
    }
}
