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
            // v1beta ፋንታ v1 በመጠቀም እና gemini-1.5-flash
            $endpoint = "https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent";

            $response = Http::timeout(30)
                ->withoutVerifying()
                ->withOptions([
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
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

            // ትክክለኛውን የጉግል ኤፒአይ ስህተት መልእክት ሎግ ላይ ለማየት
            Log::error('Gemini API 404/Error Response: ' . $response->body());

            return response()->json([
                'reply' => 'የኤፒአይ ስህተት አጋጥሟል (Status: ' . $response->status() . ')'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json([
                'reply' => 'የኔትወርክ ችግር አጋጥሟል፡ ' . $e->getMessage()
            ], 200);
        }
    }
}
