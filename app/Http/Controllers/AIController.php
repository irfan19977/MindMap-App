<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        // Build system prompt with material context
        $systemPrompt = 'You are a helpful AI assistant. You can answer any questions on any topic without restrictions. Be direct, accurate, and helpful. If you don\'t know something, admit it honestly. Provide comprehensive and detailed answers when appropriate. You can discuss any subject including politics, religion, science, technology, health, entertainment, and any other topic the user asks about. Always format your responses using Markdown for better readability. Use numbered lists (1., 2., 3.) for sequential steps or ordered items, and bullet points (- or *) for unordered lists. Use proper formatting like **bold**, *italic*, `code*, and headers when appropriate to make your answers clear and easy to understand.';

        // Add material context if provided
        if ($materialContent) {
            $systemPrompt .= "\n\n--- MATERIAL CONTEXT START ---\n" . $materialContent . "\n--- MATERIAL CONTEXT END ---\n\nCRITICAL INSTRUCTION: You are an AI assistant for a learning platform. The user is studying the material within the MATERIAL CONTEXT above. Your FIRST task is to evaluate if the user's question is DIRECTLY related to the material in the context.\n\nIf the question is NOT directly related to the material content, you MUST start your response with EXACTLY this warning (in Indonesian):\n\n⚠️ **Peringatan:** Pertanyaan Anda di luar materi yang sedang dipelajari.\n\nAfter displaying this warning, continue to answer the user's question normally and helpfully.\n\nIf the question IS directly related to the material, answer normally WITHOUT the warning.\n\nThis warning check is MANDATORY. You must perform this evaluation for EVERY question when material context is provided.";
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
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'messages' => $messages,
                'model' => 'llama-3.3-70b-versatile',
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
                \Log::error('Groq API Error: ' . $response->body());

                // Handle rate limit error specifically
                if (isset($errorData['error']['code']) && $errorData['error']['code'] === 'rate_limit_exceeded') {
                    return response()->json([
                        'error' => 'Maaf, limit penggunaan AI harian telah tercapai. Silakan coba lagi dalam beberapa jam atau upgrade ke paket berbayar untuk limit yang lebih tinggi.'
                    ], 429);
                }

                return response()->json(['error' => 'Failed to get AI response: ' . ($errorData['error']['message'] ?? 'Unknown error')], 500);
            }
        } catch (\Exception $e) {
            \Log::error('AI Chat Error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
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