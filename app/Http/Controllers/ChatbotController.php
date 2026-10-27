<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $validated = $request->validate([
            'messages' => ['required', 'array', 'min:1', 'max:10'],
            'messages.*.role' => ['required', 'in:user,assistant'],
            'messages.*.content' => ['required', 'string', 'max:2000'],
        ]);

        $messages = $validated['messages'];

        if (end($messages)['role'] !== 'user') {
            return response()->json([
                'reply' => 'Please send a new message.',
            ], 422);
        }

        // Check Groq API key
        $apiKey = config('services.groq.key');

        if (empty($apiKey)) {
            return response()->json([
                'reply' => 'Groq API key is missing. Please check configuration.',
            ], 503);
        }

        $instructions = <<<'PROMPT'
You are the official AI assistant for LDTECS.

Help visitors understand LDTECS products and services,
including Classifier Elite, Classifier Lite, Classifier Nano,
software development, AI/ML, embedded systems, automation,
CAD design, R&D, and 3D printing.

Reply in Hindi when the visitor writes in Hindi.
Reply in English when the visitor writes in English.
Reply naturally in Hinglish when appropriate.

Be friendly, concise, and professional.
Never invent product specifications, prices, contact details,
or company facts. If information is unavailable, tell the
visitor to contact the LDTECS team through the website.
PROMPT;

        try {
            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->connectTimeout(10)
                ->timeout(60)
                ->post(
                    'https://api.groq.com/openai/v1/chat/completions',
                    [
                        'model' => 'openai/gpt-oss-20b',
                        'messages' => array_merge([
                            [
                                'role' => 'system',
                                'content' => $instructions,
                            ],
                        ], $messages),
                        'max_tokens' => 400,
                        'temperature' => 0.7,
                    ]
                );

            if ($response->failed()) {
                Log::error('LDTECS Groq API error', [
                    'status' => $response->status(),
                    'error' => $response->json('error.message'),
                ]);

                return response()->json([
                    'reply' => 'AI service is temporarily unavailable. Please try again later.',
                ], 503);
            }

            $reply = $response->json('choices.0.message.content');

            return response()->json([
                'reply' => $reply ?: 'Sorry, please try again.',
            ]);

        } catch (Throwable $exception) {
            Log::error('LDTECS chatbot request failed', [
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'reply' => 'AI service is temporarily unavailable. Please try again later.',
            ], 503);
        }
    }
}