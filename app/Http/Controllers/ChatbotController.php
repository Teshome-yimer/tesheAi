<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $userMessage = $request->input('message');
        $apiKey = env('OPENAI_API_KEY'); // AletCloud ላይ ያስገባኸው የ OpenAI ቁልፍ

        if (!$apiKey) {
            return response()->json(['error' => 'API Key አልተገኘም'], 500);
        }

        try {
            // ወደ OpenAI API ጥያቄ መላክ
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->withoutVerifying() // SSL ችግር ካለ ለማለፍ
              ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini', // በጣም ፈጣን እና ርካሽ የሆነው የ ChatGPT ሞዴል
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'አንተ TesheAi Assistant ነህ። ለተማሪዎች እና ለተጠቃሚዎች በትህትና እና በጥራት በአማርኛ ወይም በእንግሊዝኛ ምላሽ የምትሰጥ ረዳት ነህ።'
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage
                    ]
                ],
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $botResponse = $response->json()['choices'][0]['message']['content'];
                return response()->json(['reply' => $botResponse]);
            } else {
                return response()->json([
                    'error' => 'የኤፒአይ ስህተት ተፈጥሯል (ኮድ: ' . $response->status() . ')'
                ], $response->status());
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'የሰርቨር ስህተት፦ ' . $e->getMessage()], 500);
        }
    }
}
