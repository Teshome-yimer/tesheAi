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
            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent";

            // AletCloud ኔትወርክ ከጉግል ጋር ያለውን ግንኙነት እንዲያቀልጥ cURL options እናስገባለን
            $response = Http::timeout(30)
                ->withoutVerifying()
                ->withOptions([
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4, // ኔትወርኩ በ IPv4 እንዲያልፍ ማስገደድ
                    ],
                ])
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
                $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'ምንም ምላሽ አልተገኘም።';

                return response()->json(['reply' => $botReply], 200);
            }

            // ኤፒአይው የተመለሰበትን ትክክለኛ የጉግል ስህተት ወደ ሰርቨር ሎግ እንመዝግባለን
            Log::error('Gemini API Connection Error Response: ' . $response->body());

            return response()->json([
                'reply' => 'ይቅርታ፣ ከኤአይ ሰርቨር ጋር የሚደረገው ግንኙነት ታግዷል። (Error code: ' . $response->status() . ')'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Chatbot Network Exception: ' . $e->getMessage());
            return response()->json([
                'reply' => 'የኔትወርክ ማነቆ አጋጥሟል፡ ' . $e->getMessage()
            ], 200);
        }
    }
}
