<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function handleChat(Request $request)
    {
        // 1. የተጠቃሚውን መልእክት ማረጋገጥ (Validation)
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY') ?? config('services.gemini.key');

        // የ API Key በ .env ላይ ካልተገኘ
        if (!$apiKey) {
            Log::error('Gemini API Key is missing in .env file.');
            return response()->json([
                'reply' => 'ይቅርታ፣ የ ኤፒአይ ቁልፍ (API Key) በሰርቨሩ ላይ አልተገኘም።'
            ]);
        }

        try {
            // 2. የሚሞከሩትን የሞዴሎች ዝርዝር በአንድ አርሬ (Array) ውስጥ ማስቀመጥ
            $models = [
                'gemini-flash-latest',
                'gemini-pro',
                'gemini-1.5-flash'
            ];

            $response = null;
            $success = false;

            // 3. አንዱ ሞዴል ሲሳሳት ቀጣዩን በቅደም ተከተል መሞከር (Fallback Loop)
            foreach ($models as $modelName) {
                $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent";

                $response = Http::timeout(15)
                    ->withoutVerifying() // በሰርቨር ላይ የ SSL ሰርተፍኬት ችግር እንዳይኖር
                    ->withHeaders([
                        'Content-Type' => 'application/json',
                        'X-goog-api-key' => $apiKey,
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
                    $success = true;
                    break; // ከነዚህ ሞዴሎች አንዱ በትክክል ስኬታማ ከሆነ ሉፑ ይቆማል
                }
            }

            // 4. የተሳካ ምላሽ ከተገኘ ለተጠቃሚው መመለስ
            if ($success && $response->successful()) {
                $data = $response->json();
                $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'ምንም ምላሽ ማግኘት አልተቻለም።';

                return response()->json([
                    'reply' => $botReply
                ]);
            }

            // ሁሉም ሞዴሎች ካልሠሩ ሎግ ላይ መዝገብ ማስቀመጥ
            Log::error('All Gemini Models Failed. Last Error: ' . ($response ? $response->body() : 'No response'));
            return response()->json([
                'reply' => 'ይቅርታ፣ በአሁኑ ሰዓት ከሁሉም የ AI ሞዴሎች ጋር መገናኘት አልተቻለም።'
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json([
                'reply' => 'የኔትወርክ ወይም የሲስተም ችግር አጋጥሟል፡ ' . $e->getMessage()
            ], 500);
        }
    }
}
