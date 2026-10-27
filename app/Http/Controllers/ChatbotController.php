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
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return response()->json(['reply' => 'የኤፒአይ ቁልፍ በሰርቨር አልተገኘም።'], 200);
        }

        try {
            // ያዘዝከው ትክክለኛ የ cURL ዩአርኤል (gemini-flash-latest)
            // ከፍተኛ የጥያቄ መጠን የሚቀበል እና የተረጋጋ ሞዴል
$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent";

            $response = Http::timeout(30)
                ->withoutVerifying()
                ->withOptions([
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    ],
                ])
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-goog-api-key' => $apiKey, // የላከው ትክክለኛ ሄደር
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
                $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'ምንም ምላሽ አልተገኘም።';

                return response()->json(['reply' => $botReply], 200);
            }

            // ኤፒአይው የተመለሰበትን ትክክለኛ ስህተት በሰርቨር ሎግ ላይ እንመዝግባለን
            Log::error('Gemini API Error Response: ' . $response->body());

            return response()->json([
                'reply' => 'የኤፒአይ ስህተት ተፈጥሯል (ኮድ: ' . $response->status() . ')'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json([
                'reply' => 'የኔትወርክ ችግር አጋጥሟል፡ ' . $e->getMessage()
            ], 200);
        }
    }
}
