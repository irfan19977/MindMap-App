<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    /**
     * Handle AI chat requests
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array',
            'material_content' => 'nullable|string',
        ]);

        $message = $request->input('message');
        $history = $request->input('history', []);
        $materialContent = $request->input('material_content', '');

        // Determine if user is a student
        $user = Auth::user();
        $isStudent = $user && (
            $user->user_type === 'student' || $user->hasRole('student')
        );

        // Build system prompt with material context
        $systemPrompt = 'You are a helpful AI assistant for a learning platform. Your primary role is to help students understand and learn the material they are studying. Be direct, accurate, and helpful. If you don\'t know something, admit it honestly. Provide comprehensive and detailed answers when appropriate. Always format your responses using Markdown for better readability. Use numbered lists (1., 2., 3.) for sequential steps or ordered items, and bullet points (- or *) for unordered lists. Use proper formatting like **bold**, *italic*, `code*, and headers when appropriate to make your answers clear and easy to understand. Always respond in Indonesian.';

        // Add student-specific instruction to refuse summaries/shortcuts
        if ($isStudent) {
            $systemPrompt .= "\n\nCRITICAL STUDENT INSTRUCTION: The current user is a STUDENT. You MUST NOT provide summaries, rangkuman, ringkasan, shortcuts, or ready-made answers that bypass learning. If the student asks for a summary, asks you to 'jelaskan singkat', 'buat rangkuman', 'buat ringkasan', 'kasih jawaban', or any similar shortcut, politely refuse and instead guide them to understand the concept step-by-step. Ask guiding questions, explain the underlying idea, and encourage active learning. Always respond in Indonesian.";
        }

        // Add material context if provided
        if ($materialContent) {
            $systemPrompt .= "\n\n--- MATERIAL CONTEXT START ---\n" . $materialContent . "\n--- MATERIAL CONTEXT END ---\n\nCRITICAL INSTRUCTION: You are an AI assistant for a learning platform. The user is studying the material within the MATERIAL CONTEXT above. Your FIRST task is to evaluate the user's question.\n\n1. If the user asks general questions like 'apakah kamu bisa membantu saya', 'bisa bantu saya', 'siap membantu', 'apa yang bisa kamu lakukan', or similar greetings/offers to help, respond with: 'Halo! Saya siap membantu Anda belajar materi ini. Apa yang ingin Anda tanyakan atau yang membingungkan Anda dari materi [judul materi]?'\n\n2. If the question is NOT directly related to the material content, you MUST respond with EXACTLY this warning (in Indonesian) and NOTHING ELSE:\n\n⚠️ **Peringatan:** Pertanyaan Anda di luar materi yang sedang dipelajari. Silakan tanyakan sesuatu yang terkait dengan materi ini agar saya bisa membantu Anda dengan lebih baik.\n\nDo NOT answer the question if it's outside the material. Only provide the warning.\n\n3. If the question IS directly related to the material, answer normally and helpfully.\n\nThis evaluation is MANDATORY. You must perform this check for EVERY question when material context is provided.";
        }

        // Build messages array for API
        $messages = [
            [
                'role' => 'system',
                'content' => $systemPrompt
            ]
        ];

        // Add conversation history
        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'] === 'user' ? 'user' : 'assistant',
                'content' => $msg['message']
            ];
        }

        // Add current message
        $messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        // Call Groq API
        $apiKey = env('GROQ_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'API key not configured'], 500);
        }

        try {
            // MODEL AI
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'messages' => $messages,
                'model' => 'openai/gpt-oss-20b',
                'temperature' => 0.7,
                'max_tokens' => 2048,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $aiMessage = $data['choices'][0]['message']['content'];

                return response()->json([
                    'message' => $aiMessage,
                ]);
            } else {
                $errorData = $response->json();
                Log::error('Groq API Error: ' . $response->body());

                // Handle rate limit error specifically
                if (isset($errorData['error']['code']) && $errorData['error']['code'] === 'rate_limit_exceeded') {
                    return response()->json([
                        'error' => 'Maaf, limit penggunaan AI harian telah tercapai. Silakan coba lagi dalam beberapa jam atau upgrade ke paket berbayar untuk limit yang lebih tinggi.'
                    ], 429);
                }

                return response()->json(['error' => 'Failed to get AI response: ' . ($errorData['error']['message'] ?? 'Unknown error')], 500);
            }
        } catch (\Exception $e) {
            Log::error('AI Chat Error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    /**
     * Grade essay answer using AI
     */
    public function gradeEssay(Request $request)
    {
        $request->validate([
            'question'       => 'required|string',
            'user_answer'    => 'required|string',
            'correct_answer' => 'nullable|string',
            'max_points'     => 'nullable|integer',
        ]);

        $apiKey = env('GROQ_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'API key not configured'], 500);
        }

        $question      = $request->input('question');
        $userAnswer    = $request->input('user_answer');
        $correctAnswer = $request->input('correct_answer', '');
        $maxPoints     = $request->input('max_points', 10); // Default 10 points if not specified

        $prompt = "Kamu adalah guru yang bijak dan adil dalam mengoreksi jawaban essay siswa untuk level SD (sekolah dasar). Berikan penilaian dalam Bahasa Indonesia.\n\n";
        $prompt .= "**Soal:** {$question}\n\n";
        $prompt .= "**Jawaban Siswa:** {$userAnswer}\n\n";
        if ($correctAnswer) {
            $prompt .= "**Referensi Jawaban (dari guru):** {$correctAnswer}\n\n";
        }
        $prompt .= "PENTING: Poin maksimal untuk soal ini adalah **{$maxPoints} poin**.\n";
        $prompt .= "Kamu harus memberikan nilai dalam skala 0-{$maxPoints}, bukan 0-100.\n\n";
        $prompt .= "KRITERIA PENILAIAN (Level SD):\n";
        $prompt .= "- **Jika soal meminta kalimat:** Jawaban harus berupa kalimat lengkap dengan subjek dan predikat. Kalimat pendek seperti 'aku bersih' tidak cukup untuk mendapat nilai penuh.\n";
        $prompt .= "- **Jika soal meminta definisi/arti kata:** Jawaban yang menjelaskan konsep dengan benar sudah cukup untuk nilai penuh atau hampir penuh. Jangan terlalu ketat untuk jawaban definisi level SD.\n";
        $prompt .= "- **Poin penuh ({$maxPoints}):** Untuk definisi: jika jawaban benar secara konsep dan wajar untuk level SD. Untuk kalimat: jika jawaban lengkap dan tepat.\n";
        $prompt .= "- **Sebagian Benar ({$maxPoints}-2 atau {$maxPoints}-3):** Jika jawaban benar secara konsep tapi bisa diperbaiki atau ditambah detail.\n";
        $prompt .= "- **Kurang Tepat ({$maxPoints}/3 atau kurang):** Jika jawaban salah konsep, terlalu pendek, atau tidak relevan.\n\n";
        $prompt .= "Contoh penilaian (Level SD):\n";
        $prompt .= "- Soal: 'Apa arti kata hemat?' → Jawaban: 'menggunakan sesuatu dengan tidak berlebihan' → **Benar** ({$maxPoints} poin) - definisi yang tepat untuk level SD\n";
        $prompt .= "- Soal: 'Buat kalimat menggunakan kata bersih' → Jawaban: 'aku bersih' → **Kurang Tepat** (3-4 poin) - bukan kalimat lengkap\n";
        $prompt .= "- Soal: 'Buat kalimat menggunakan kata bersih' → Jawaban: 'Aku membersihkan kamar setiap hari' → **Benar** ({$maxPoints} poin) - kalimat lengkap\n\n";
        $prompt .= "Format response WAJIB dalam JSON:\n{\"score\": <angka 0-{$maxPoints}>, \"verdict\": \"Benar|Sebagian Benar|Kurang Tepat\", \"feedback\": \"<penjelasan singkat>\", \"suggestion\": \"<saran atau null>\"}";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'messages' => [
                    ['role' => 'system', 'content' => 'Kamu adalah guru yang mengoreksi jawaban essay. Selalu jawab dalam format JSON yang diminta.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'model'       => 'openai/gpt-oss-20b',
                'temperature' => 0.3,
                'max_tokens'  => 512,
            ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'];
                // Extract JSON from response
                preg_match('/\{.*\}/s', $content, $matches);
                $result = $matches ? json_decode($matches[0], true) : null;

                if ($result) {
                    // If AI still gives score in 0-100 scale, convert to max_points scale
                    if (isset($result['score']) && $result['score'] > $maxPoints) {
                        $result['score'] = round(($result['score'] / 100) * $maxPoints);
                    }

                    // Ensure score doesn't exceed max_points
                    if (isset($result['score']) && $result['score'] > $maxPoints) {
                        $result['score'] = $maxPoints;
                    }

                    return response()->json(['success' => true, 'result' => $result, 'max_points' => $maxPoints]);
                }
                return response()->json(['success' => false, 'error' => 'Gagal memparse respons AI']);
            }

            return response()->json(['success' => false, 'error' => 'Gagal menghubungi AI'], 500);
        } catch (\Exception $e) {
            Log::error('Grade Essay Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Terjadi kesalahan'], 500);
        }
    }

    /**
     * Get chat history for a session (not used - no database storage)
     */
    public function getHistory(Request $request)
    {
        return response()->json([
            'messages' => [],
        ]);
    }
}
