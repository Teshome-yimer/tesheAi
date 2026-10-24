<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function handleChat(Request $request)
    {
        // 1. መረጃውን ማረጋገጥ (ከመጠን በላይ ረጅም መልእክት ወይም ባዶ እንዳይሆን)
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');

        // የ API Key በ .env ላይ ካልተገኘ ድረ-ገጹ እንዳይበላሽ መከላከል
        if (!$apiKey) {
            Log::error('Gemini API Key is missing in .env file.');
            return response()->json([
                'reply' => 'ይቅርታ፣ በሰርቨራችን ላይ ትንሽ ችግር አጋጥሟል። እባክዎ ቆይተው ይሞክሩ።'
            ], 500);
        }

        try {
            // 2. ከ Gemini API ጋር ማገናኘት (የ10 ሰከንድ Timeout በማስገባት)
            $response = Http::timeout(10)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
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
