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
            ], 200);
        }

        try {
            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent";

          $response = Http::timeout(30)
    ->withoutVerifying() // የ SSL ሰርተፍኬት ችግር እንዳይፈጥር
    ->withHeaders([
        'Content-Type' => 'application/json',
        'x-goog-api-key' => $apiKey,
    ])
    ->post($endpoint, [
        'contents' => [
            [
                'parts' => [
                    ['text' => $userMessage]
                ]
            ]
        ]
    ]);

            if ($response->successful()) {
                $data = $response->json();
                $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'ምንም ምላሽ ማግኘት አልተቻለም።';

                return response()->json([
                    'reply' => $botReply
                ], 200);
            }

            Log::error('Gemini API Error: ' . $response->body());
            return response()->json([
                'reply' => 'በአሁኑ ሰዓት ትንሽ የኔትወርክ መዘግየት አለ። የ TesheAi ረዳት ከጎንዎ አለ፤ ከላይ ያሉትን ኮርሶች በመመልከት መማር መቀጠል ወይም ጥያቄዎን ትንሽ ቆይተው እንደገና መሞከር ይችላሉ!'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            // 500 ፋንታ 200 እንመልሳለን፣ ይህም ብራውዘር ላይ 500 Server Error እንዳይመጣ ያደርጋል
            return response()->json([
                'reply' => 'ይቅርታ፣ የኔትወርክ መዘግየት አጋጥሟል። እባክዎን ትንሽ ቆይተው እንደገና ይሞክሩ።'
            ], 200);
        }
    }
}
