<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use App\Models\PracticeQuestion;
use App\Models\PracticeAnswer;
use Carbon\Carbon;

class QuizAndPracticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user
        $user = User::first();
        
        if (!$user) {
            $this->command->warn('No user found. Please create a user first.');
            return;
        }

        // Get all materials
        $materials = Material::all();

        if ($materials->isEmpty()) {
            $this->command->warn('No materials found. Please run SampleDataSeeder first.');
            return;
        }

        // Create quizzes for some materials
        $quizzes = [
            [
                'material_id' => $materials[0]->id,
                'title' => 'Kuis Variabel dan Konstanta',
                'description' => 'Tes pemahaman tentang variabel dan konstanta',
                'time_limit' => 15,
                'passing_score' => 70,
                'status' => 'publish',
            ],
            [
                'material_id' => $materials[2]->id,
                'title' => 'Kuis Bangun Datar',
                'description' => 'Tes pemahaman tentang bangun datar segiempat',
                'time_limit' => 20,
                'passing_score' => 60,
                'status' => 'publish',
            ],
        ];

        foreach ($quizzes as $quizData) {
            Quiz::create($quizData);
        }

        // Get created quizzes
        $quizzes = Quiz::all();

        // Create quiz questions
        $quizQuestions = [
            [
                'quiz_id' => $quizzes[0]->id,
                'question' => 'Apa yang dimaksud dengan variabel?',
                'options' => json_encode(['A' => 'Nilai yang tetap', 'B' => 'Simbol untuk nilai tidak diketahui', 'C' => 'Hasil penjumlahan', 'D' => 'Angka desimal']),
                'correct_answer' => 'B',
                'explanation' => 'Variabel adalah simbol yang mewakili nilai yang tidak diketahui atau dapat berubah.',
                'points' => 10,
            ],
            [
                'quiz_id' => $quizzes[0]->id,
                'question' => 'Apa yang dimaksud dengan konstanta?',
                'options' => json_encode(['A' => 'Nilai yang tetap', 'B' => 'Simbol untuk nilai tidak diketahui', 'C' => 'Hasil perkalian', 'D' => 'Angka negatif']),
                'correct_answer' => 'A',
                'explanation' => 'Konstanta adalah nilai yang tetap dan tidak berubah.',
                'points' => 10,
            ],
            [
                'quiz_id' => $quizzes[1]->id,
                'question' => 'Berapa jumlah sudut pada segiempat?',
                'options' => json_encode(['A' => '2 sudut', 'B' => '3 sudut', 'C' => '4 sudut', 'D' => '5 sudut']),
                'correct_answer' => 'C',
                'explanation' => 'Segiempat memiliki 4 sudut.',
                'points' => 10,
            ],
        ];

        foreach ($quizQuestions as $questionData) {
            QuizQuestion::create($questionData);
        }

        // Create quiz attempts for the user
        $quizAttempts = [
            [
                'quiz_id' => $quizzes[0]->id,
                'score' => 100,
                'total_points' => 20,
                'earned_points' => 20,
                'status' => 'passed',
                'started_at' => Carbon::now()->subDays(5)->subMinutes(15),
                'completed_at' => Carbon::now()->subDays(5),
            ],
            [
                'quiz_id' => $quizzes[1]->id,
                'score' => 80,
                'total_points' => 10,
                'earned_points' => 8,
                'status' => 'passed',
                'started_at' => Carbon::now()->subDays(2)->subMinutes(20),
                'completed_at' => Carbon::now()->subDays(2),
            ],
        ];

        foreach ($quizAttempts as $attemptData) {
            $attempt = QuizAttempt::create([
                'user_id' => $user->id,
                'quiz_id' => $attemptData['quiz_id'],
                'score' => $attemptData['score'],
                'total_points' => $attemptData['total_points'],
                'earned_points' => $attemptData['earned_points'],
                'status' => $attemptData['status'],
                'started_at' => $attemptData['started_at'],
                'completed_at' => $attemptData['completed_at'],
            ]);

            // Create quiz answers for this attempt
            $quizQuestionsForQuiz = QuizQuestion::where('quiz_id', $attemptData['quiz_id'])->get();
            
            foreach ($quizQuestionsForQuiz as $index => $question) {
                $isCorrect = $index === 0 || ($attemptData['quiz_id'] == $quizzes[1]->id);
                
                QuizAnswer::create([
                    'quiz_attempt_id' => $attempt->id,
                    'quiz_question_id' => $question->id,
                    'user_answer' => $question->correct_answer,
                    'is_correct' => $isCorrect,
                    'points_earned' => $isCorrect ? $question->points : 0,
                ]);
            }
        }

        // Create practice questions
        $practiceQuestions = [
            [
                'material_id' => $materials[0]->id,
                'question' => 'Jelaskan perbedaan antara variabel dan konstanta!',
                'question_type' => 'essay',
                'correct_answer' => 'Variabel adalah simbol untuk nilai yang tidak diketahui, sedangkan konstanta adalah nilai yang tetap.',
                'explanation' => 'Variabel dapat berubah-ubah, konstanta selalu sama.',
                'points' => 5,
            ],
            [
                'material_id' => $materials[1]->id,
                'question' => 'Hitunglah: 3x + 2x jika x = 5',
                'question_type' => 'essay',
                'correct_answer' => '25',
                'explanation' => '3x + 2x = 5x = 5(5) = 25',
                'points' => 5,
            ],
            [
                'material_id' => $materials[2]->id,
                'question' => 'Sebutkan 3 jenis segiempat!',
                'question_type' => 'essay',
                'correct_answer' => 'Persegi, persegi panjang, jajar genjang',
                'explanation' => 'Ada banyak jenis segiempat seperti persegi, persegi panjang, jajar genjang, belah ketupat, dll.',
                'points' => 5,
            ],
        ];

        foreach ($practiceQuestions as $questionData) {
            PracticeQuestion::create($questionData);
        }

        // Create practice answers for the user
        $practiceAnswers = [
            [
                'practice_question_id' => PracticeQuestion::first()->id,
                'user_answer' => 'Variabel adalah simbol untuk nilai yang tidak diketahui, konstanta adalah nilai yang tetap.',
                'is_correct' => true,
            ],
            [
                'practice_question_id' => PracticeQuestion::skip(1)->first()->id,
                'user_answer' => '25',
                'is_correct' => true,
            ],
            [
                'practice_question_id' => PracticeQuestion::skip(2)->first()->id,
                'user_answer' => 'Persegi, persegi panjang, trapesium',
                'is_correct' => false,
            ],
        ];

        foreach ($practiceAnswers as $answerData) {
            PracticeAnswer::create([
                'user_id' => $user->id,
                'practice_question_id' => $answerData['practice_question_id'],
                'user_answer' => $answerData['user_answer'],
                'is_correct' => $answerData['is_correct'],
            ]);
        }

        $this->command->info('Quiz and practice data created successfully for user: ' . $user->name);
    }
}
