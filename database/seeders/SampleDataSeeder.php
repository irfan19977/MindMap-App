<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Material;
use App\Models\User;
use App\Models\UserProgress;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use App\Models\PracticeQuestion;
use App\Models\PracticeAnswer;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample categories
        $categories = [
            ['name' => 'Matematika', 'slug' => 'matematika', 'description' => 'Pelajaran matematika dari dasar hingga lanjut', 'status' => 'publish'],
            ['name' => 'Fisika', 'slug' => 'fisika', 'description' => 'Pelajaran fisika dan sains', 'status' => 'publish'],
            ['name' => 'Bahasa Indonesia', 'slug' => 'bahasa-indonesia', 'description' => 'Pelajaran bahasa Indonesia', 'status' => 'publish'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Get categories
        $mathCategory = Category::where('slug', 'matematika')->first();
        $physicsCategory = Category::where('slug', 'fisika')->first();
        $indoCategory = Category::where('slug', 'bahasa-indonesia')->first();

        // Create sample subcategories
        $subcategories = [
            ['category_id' => $mathCategory->id, 'name' => 'Aljabar', 'slug' => 'aljabar', 'grade_level' => 'smp', 'status' => 'publish'],
            ['category_id' => $mathCategory->id, 'name' => 'Geometri', 'slug' => 'geometri', 'grade_level' => 'smp', 'status' => 'publish'],
            ['category_id' => $physicsCategory->id, 'name' => 'Mekanika', 'slug' => 'mekanika', 'grade_level' => 'sma', 'status' => 'publish'],
            ['category_id' => $indoCategory->id, 'name' => 'Tata Bahasa', 'slug' => 'tata-bahasa', 'grade_level' => 'sd', 'status' => 'publish'],
        ];

        foreach ($subcategories as $subcategory) {
            Subcategory::create($subcategory);
        }

        // Get subcategories
        $aljabarSub = Subcategory::where('slug', 'aljabar')->first();
        $geometriSub = Subcategory::where('slug', 'geometri')->first();
        $mekanikaSub = Subcategory::where('slug', 'mekanika')->first();
        $tataBahasaSub = Subcategory::where('slug', 'tata-bahasa')->first();

        // Create sample materials
        $materials = [
            [
                'subcategory_id' => $aljabarSub->id,
                'title' => 'Pengenalan Variabel dan Konstanta',
                'slug' => 'pengenalan-variabel-konstanta',
                'description' => 'Memahami konsep dasar variabel dan konstanta dalam aljabar',
                'learning_objectives' => 'Siswa dapat membedakan variabel dan konstanta',
                'content' => 'Variabel adalah simbol yang mewakili nilai yang tidak diketahui. Konstanta adalah nilai yang tetap.',
                'status' => 'publish',
                'is_free' => true,
            ],
            [
                'subcategory_id' => $aljabarSub->id,
                'title' => 'Operasi Penjumlahan dan Pengurangan',
                'slug' => 'operasi-penjumlahan-pengurangan',
                'description' => 'Belajar operasi dasar aljabar',
                'learning_objectives' => 'Siswa dapat melakukan operasi penjumlahan dan pengurangan aljabar',
                'content' => 'Operasi penjumlahan dan pengurangan pada aljabar mengikuti aturan yang sama dengan bilangan biasa.',
                'status' => 'publish',
                'is_free' => true,
            ],
            [
                'subcategory_id' => $geometriSub->id,
                'title' => 'Bangun Datar Segiempat',
                'slug' => 'bangun-datar-segiempat',
                'description' => 'Mengenal berbagai jenis bangun datar segiempat',
                'learning_objectives' => 'Siswa dapat mengidentifikasi jenis-jenis segiempat',
                'content' => 'Segiempat adalah bangun datar dengan empat sisi dan empat sudut.',
                'status' => 'publish',
                'is_free' => true,
            ],
            [
                'subcategory_id' => $mekanikaSub->id,
                'title' => 'Hukum Newton I',
                'slug' => 'hukum-newton-i',
                'description' => 'Memahami hukum pertama Newton tentang inersia',
                'learning_objectives' => 'Siswa dapat menjelaskan konsep inersia',
                'content' => 'Hukum Newton I menyatakan bahwa benda akan tetap diam atau bergerak lurus beraturan jika tidak ada gaya yang bekerja.',
                'status' => 'publish',
                'is_free' => true,
            ],
            [
                'subcategory_id' => $tataBahasaSub->id,
                'title' => 'Kata Benda dan Kata Kerja',
                'slug' => 'kata-benda-kata-kerja',
                'description' => 'Mengenal kata benda dan kata kerja dalam bahasa Indonesia',
                'learning_objectives' => 'Siswa dapat membedakan kata benda dan kata kerja',
                'content' => 'Kata benda adalah kata yang menyatakan benda atau konsep. Kata kerja adalah kata yang menyatakan tindakan.',
                'status' => 'publish',
                'is_free' => true,
            ],
        ];

        foreach ($materials as $material) {
            Material::create($material);
        }

        $this->command->info('Sample data created successfully!');
    }
}
