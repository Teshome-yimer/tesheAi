<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function handleChat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY') ?? config('services.gemini.key');

        if (!$apiKey) {
            Log::error('Gemini API Key is missing in .env file.');
            return response()->json([
                'reply' => 'ይቅርታ፣ የ ኤፒአይ ቁልፍ (API Key) አልተገኘም።'
            ]);
        }

        try {
            // ከ cURL ጋር አንድ አይነት የሆነው ትክክለኛው የ API ጥሪ
            $response = Http::timeout(15)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-goog-api-key' => $apiKey,
                ])
                ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent', [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => "እርስዎ የ TesheAi አካዳሚ የኢ-ሊርኒንግ መድረክ AI ረዳት ነዎት። ለተጠቃሚው ጥያቄ በአጭሩና በጥሩ ሁኔታ በአማርኛ ወይም በእንግሊዝኛ ምላሽ ይስጡ። የተጠቃሚው መልእክት፦ " . $userMessage]
                            ]
                        ]
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'ምንም ምላሽ ማግኘት አልተቻለም።';

                return response()->json([
                    'reply' => $botReply
                ]);
            }

            Log::error('Gemini API Error: ' . $response->body());
            return response()->json([
                'reply' => 'ይቅርታ፣ በአሁኑ ሰዓት ምላሽ መስጠት አልቻልኩም።'
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json([
                'reply' => 'የኔትወርክ ወይም የሲስተም ችግር አጋጥሟል። እባክዎ ጥቂት ቆይተው ይሞክሩ።'
            ], 500);
        }
    }
}
