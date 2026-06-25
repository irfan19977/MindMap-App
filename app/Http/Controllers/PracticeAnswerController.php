<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PracticeAnswer;
use App\Models\PracticeQuestion;
use Illuminate\Support\Facades\Auth;

class PracticeAnswerController extends Controller
{
    /**
     * Store a newly created practice answer with auto-scoring.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'practice_question_id' => 'required|uuid|exists:practice_questions,id',
            'user_answer' => 'required|string',
        ]);

        $question = PracticeQuestion::findOrFail($validated['practice_question_id']);
        
        // Auto-scoring logic
        $isCorrect = $this->checkAnswer($question, $validated['user_answer']);
        $pointsEarned = $isCorrect ? $question->points : 0;

        // Check if user already answered this question
        $existingAnswer = PracticeAnswer::where('user_id', Auth::id())
            ->where('practice_question_id', $validated['practice_question_id'])
            ->first();

        if ($existingAnswer) {
            // Update existing answer
            $existingAnswer->update([
                'user_answer' => $validated['user_answer'],
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Jawaban berhasil diperbarui',
                'is_correct' => $isCorrect,
                'points_earned' => $pointsEarned,
                'correct_answer' => $question->correct_answer,
                'explanation' => $question->explanation,
            ]);
        }

        // Create new answer
        $answer = PracticeAnswer::create([
            'user_id' => Auth::id(),
            'practice_question_id' => $validated['practice_question_id'],
            'user_answer' => $validated['user_answer'],
            'is_correct' => $isCorrect,
            'points_earned' => $pointsEarned,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil disimpan',
            'is_correct' => $isCorrect,
            'points_earned' => $pointsEarned,
            'correct_answer' => $question->correct_answer,
            'explanation' => $question->explanation,
        ]);
    }

    /**
     * Check if user answer is correct based on question type
     */
    private function checkAnswer(PracticeQuestion $question, string $userAnswer): bool
    {
        $correctAnswer = trim(strtolower($question->correct_answer));
        $userAnswer = trim(strtolower($userAnswer));

        if ($question->question_type === 'multiple_choice') {
            // For multiple choice, exact match required
            return $userAnswer === $correctAnswer;
        }

        // For essay questions, use more flexible comparison
        // Remove extra whitespace and compare
        $correctWords = preg_replace('/\s+/', ' ', $correctAnswer);
        $userWords = preg_replace('/\s+/', ' ', $userAnswer);

        // Check for exact match first
        if ($correctWords === $userWords) {
            return true;
        }

        // Check if user answer contains the correct answer (for short answers)
        if (strlen($correctWords) > 0 && strpos($userWords, $correctWords) !== false) {
            return true;
        }

        // Check similarity for longer answers (simple word overlap)
        $correctArray = explode(' ', $correctWords);
        $userArray = explode(' ', $userWords);
        
        $matches = 0;
        foreach ($correctArray as $word) {
            if (in_array($word, $userArray)) {
                $matches++;
            }
        }

        // If 70% of words match, consider it correct
        $percentage = count($correctArray) > 0 ? ($matches / count($correctArray)) * 100 : 0;
        return $percentage >= 70;
    }

    /**
     * Get user's practice answers for a specific material
     */
    public function getAnswersByMaterial($materialId)
    {
        $answers = PracticeAnswer::with('practiceQuestion')
            ->where('user_id', Auth::id())
            ->whereHas('practiceQuestion', function($query) use ($materialId) {
                $query->where('material_id', $materialId);
            })
            ->get();

        $totalPoints = $answers->sum('points_earned');
        $totalPossible = $answers->sum(function($answer) {
            return $answer->practiceQuestion->points;
        });

        return response()->json([
            'answers' => $answers,
            'total_points_earned' => $totalPoints,
            'total_possible_points' => $totalPossible,
            'score_percentage' => $totalPossible > 0 ? round(($totalPoints / $totalPossible) * 100, 2) : 0,
        ]);
    }

    /**
     * Get user's total practice score
     */
    public function getTotalScore()
    {
        $answers = PracticeAnswer::with('practiceQuestion')
            ->where('user_id', Auth::id())
            ->get();

        $totalPoints = $answers->sum('points_earned');
        $totalPossible = $answers->sum(function($answer) {
            return $answer->practiceQuestion->points;
        });
        $correctCount = $answers->where('is_correct', true)->count();
        $totalCount = $answers->count();

        return response()->json([
            'total_points_earned' => $totalPoints,
            'total_possible_points' => $totalPossible,
            'score_percentage' => $totalPossible > 0 ? round(($totalPoints / $totalPossible) * 100, 2) : 0,
            'correct_answers' => $correctCount,
            'total_answers' => $totalCount,
            'accuracy' => $totalCount > 0 ? round(($correctCount / $totalCount) * 100, 2) : 0,
        ]);
    }
}
