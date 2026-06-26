<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Support\Str;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Quiz 1: Matematika Dasar
        $quiz1 = Quiz::create([
            'id' => Str::uuid(),
            'material_id' => null,
            'title' => 'Matematika Dasar',
            'description' => 'Quiz matematika dasar untuk menguji pemahaman konsep fundamental',
            'time_limit' => 30,
            'passing_score' => 70,
            'status' => 'publish',
        ]);

        // Questions for Quiz 1
        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz1->id,
            'question' => 'Berapa hasil dari 15 + 27?',
            'options' => ['42', '40', '45', '38'],
            'correct_answer' => '42',
            'explanation' => '15 + 27 = 42',
            'points' => 10,
            'order_number' => 1,
        ]);

        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz1->id,
            'question' => 'Berapa hasil dari 8 × 7?',
            'options' => ['54', '56', '58', '52'],
            'correct_answer' => '56',
            'explanation' => '8 × 7 = 56',
            'points' => 10,
            'order_number' => 2,
        ]);

        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz1->id,
            'question' => 'Berapa hasil dari 100 ÷ 4?',
            'options' => ['20', '25', '24', '30'],
            'correct_answer' => '25',
            'explanation' => '100 ÷ 4 = 25',
            'points' => 10,
            'order_number' => 3,
        ]);

        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz1->id,
            'question' => 'Berapa hasil dari 45 - 18?',
            'options' => ['27', '28', '26', '25'],
            'correct_answer' => '27',
            'explanation' => '45 - 18 = 27',
            'points' => 10,
            'order_number' => 4,
        ]);

        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz1->id,
            'question' => 'Berapa hasil dari 12 × 12?',
            'options' => ['144', '124', '134', '154'],
            'correct_answer' => '144',
            'explanation' => '12 × 12 = 144',
            'points' => 10,
            'order_number' => 5,
        ]);

        // Quiz 2: Pengetahuan Umum
        $quiz2 = Quiz::create([
            'id' => Str::uuid(),
            'material_id' => null,
            'title' => 'Pengetahuan Umum',
            'description' => 'Quiz pengetahuan umum untuk menguji wawasan Anda',
            'time_limit' => 20,
            'passing_score' => 60,
            'status' => 'publish',
        ]);

        // Questions for Quiz 2
        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz2->id,
            'question' => 'Ibukota Indonesia adalah...',
            'options' => ['Surabaya', 'Bandung', 'Jakarta', 'Medan'],
            'correct_answer' => 'Jakarta',
            'explanation' => 'Jakarta adalah ibukota Indonesia',
            'points' => 10,
            'order_number' => 1,
        ]);

        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz2->id,
            'question' => 'Planet terbesar di tata surya kita adalah...',
            'options' => ['Bumi', 'Mars', 'Jupiter', 'Saturnus'],
            'correct_answer' => 'Jupiter',
            'explanation' => 'Jupiter adalah planet terbesar di tata surya',
            'points' => 10,
            'order_number' => 2,
        ]);

        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz2->id,
            'question' => 'Berapa jumlah provinsi di Indonesia?',
            'options' => ['34', '38', '33', '35'],
            'correct_answer' => '38',
            'explanation' => 'Indonesia memiliki 38 provinsi',
            'points' => 10,
            'order_number' => 3,
        ]);

        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz2->id,
            'question' => 'Bahasa pemrograman yang digunakan untuk web development adalah...',
            'options' => ['Python', 'HTML/CSS/JavaScript', 'C++', 'Java'],
            'correct_answer' => 'HTML/CSS/JavaScript',
            'explanation' => 'HTML, CSS, dan JavaScript adalah bahasa utama untuk web development',
            'points' => 10,
            'order_number' => 4,
        ]);

        // Quiz 3: Sains Dasar
        $quiz3 = Quiz::create([
            'id' => Str::uuid(),
            'material_id' => null,
            'title' => 'Sains Dasar',
            'description' => 'Quiz sains dasar untuk menguji pemahaman konsep ilmiah',
            'time_limit' => 25,
            'passing_score' => 65,
            'status' => 'publish',
        ]);

        // Questions for Quiz 3
        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz3->id,
            'question' => 'Simbol kimia untuk air adalah...',
            'options' => ['H2O', 'CO2', 'O2', 'NaCl'],
            'correct_answer' => 'H2O',
            'explanation' => 'H2O adalah rumus kimia untuk air (2 atom hidrogen, 1 atom oksigen)',
            'points' => 10,
            'order_number' => 1,
        ]);

        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz3->id,
            'question' => 'Planet yang dikenal sebagai Planet Merah adalah...',
            'options' => ['Venus', 'Mars', 'Jupiter', 'Saturnus'],
            'correct_answer' => 'Mars',
            'explanation' => 'Mars disebut Planet Merah karena warna permukaannya yang merah',
            'points' => 10,
            'order_number' => 2,
        ]);

        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz3->id,
            'question' => 'Hewan mamalia terbesar di dunia adalah...',
            'options' => ['Gajah', 'Paus Biru', 'Jerapah', 'Badak'],
            'correct_answer' => 'Paus Biru',
            'explanation' => 'Paus Biru adalah hewan mamalia terbesar di dunia',
            'points' => 10,
            'order_number' => 3,
        ]);

        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz3->id,
            'question' => 'Proses fotosintesis terjadi pada...',
            'options' => ['Hewan', 'Tumbuhan', 'Jamur', 'Bakteri'],
            'correct_answer' => 'Tumbuhan',
            'explanation' => 'Fotosintesis adalah proses pembuatan makanan pada tumbuhan hijau',
            'points' => 10,
            'order_number' => 4,
        ]);

        QuizQuestion::create([
            'id' => Str::uuid(),
            'quiz_id' => $quiz3->id,
            'question' => 'Satuan internasional untuk suhu adalah...',
            'options' => ['Fahrenheit', 'Celsius', 'Kelvin', 'Rankine'],
            'correct_answer' => 'Kelvin',
            'explanation' => 'Kelvin adalah satuan internasional (SI) untuk suhu',
            'points' => 10,
            'order_number' => 5,
        ]);

        $this->command->info('Quiz seeder completed successfully!');
    }
}
