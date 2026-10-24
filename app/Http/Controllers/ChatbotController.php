
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
                'reply' => 'ይቅርታ፣ የ ኤፒአይ ቁልፍ (API Key) በሰርቨሩ ላይ አልተገኘም።'
            ]);
        }

        try {
            // ትክክለኛውን እና በአሁኑ ሰዓት የሚሰራውን v1beta endpoint መጠቀም
            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}";

            $response = Http::timeout(20)
                ->withoutVerifying()
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($endpoint, [
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
                'reply' => 'ይቅርታ፣ በአሁኑ ሰዓት ከ AI ጋር መገናኘት አልተቻለም።'
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json([
                'reply' => 'የኔትወርክ ወይም የሲስተም ችግር አጋጥሟል፡ ' . $e->getMessage()
            ], 500);
        }
    }
}
