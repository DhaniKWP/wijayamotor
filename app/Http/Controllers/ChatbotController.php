<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Service;
use App\Models\Sparepart;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array'
        ]);

        $userMessage = $request->message;
        $history = $request->history ?? [];

        // 1. Fetch data from database (Estimates & Prices)
        $services = Service::all(['name', 'price_estimate']);
        $servicesText = $services->map(function ($s) {
            $price = $s->price_estimate ? 'Rp' . number_format($s->price_estimate, 0, ',', '.') : 'Hubungi admin';
            return "- {$s->name} (Estimasi: {$price})";
        })->implode("\n");

        $spareparts = Sparepart::all(['name', 'price']);
        $sparepartsText = $spareparts->map(function ($s) {
            return "- {$s->name} (Harga: Rp" . number_format($s->price, 0, ',', '.') . ")";
        })->implode("\n");

        // 2. Build System Prompt for Wira
        $systemPrompt = "Kamu adalah Wira (Wijaya Motor Repair Assistant), AI Customer Service untuk bengkel mobil bernama Wijaya Motor.
Tugas kamu adalah menjawab pertanyaan pelanggan dengan ramah, sopan, sabar, dan menggunakan bahasa Indonesia yang santai tapi profesional.

Berikut adalah daftar ESTIMASI biaya servis di Wijaya Motor:
{$servicesText}

Berikut adalah daftar HARGA sparepart yang ada di bengkel (harga bisa berubah sewaktu-waktu):
{$sparepartsText}

Aturan penting untuk Wira:
1. Jangan pernah memberikan data sensitif (seperti jumlah stok gudang pasti).
2. Jika ditanya ketersediaan stok, jawab bahwa secara umum barang kami sediakan, tapi untuk kepastian bisa datang langsung atau hubungi admin.
3. Selalu arahkan pelanggan untuk melakukan booking servis melalui website (tombol Booking).
4. Gunakan sapaan 'Kak' atau 'Bos'.
5. Jangan berasumsi harga jika tidak ada dalam daftar di atas, sampaikan bahwa harganya perlu dicek langsung oleh mekanik.
6. Jawaban harus singkat, padat, dan tidak bertele-tele.";

        // 3. Call Groq API
        $apiKey = env('GROQ_API_KEY');
        if (!$apiKey) {
            return response()->json(['reply' => 'Maaf, sistem Wira sedang dalam perbaikan (API Key belum diatur).']);
        }

        // Format messages for Groq API
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt]
        ];

        // Append history for context
        foreach ($history as $msg) {
            if (isset($msg['role']) && isset($msg['content'])) {
                $messages[] = ['role' => $msg['role'], 'content' => $msg['content']];
            }
        }

        // Append current user message
        $messages[] = ['role' => 'user', 'content' => $userMessage];

        try {
            // Menggunakan model Groq terbaru yang direkomendasikan
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => $messages,
                'temperature' => 0.7
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? 'Maaf Kak, Wira kurang paham.';
                return response()->json(['reply' => $reply]);
            } else {
                \Log::error('Groq API Error: ' . $response->body());
                
                // FALLBACK SOLUTION: Jika API sibuk/limit
                $mockReply = "Maaf Kak, Wira lagi pusing nih (Server AI kepenuhan antrean).\n\nTapi jangan khawatir, untuk harga servis dan sparepart bisa dicek langsung di katalog website ya, atau hubungi admin via WhatsApp!";
                return response()->json(['reply' => $mockReply]);
            }

        } catch (\Exception $e) {
            \Log::error('Groq API Exception: ' . $e->getMessage());
            return response()->json(['reply' => 'Maaf Kak, sistem Wira sedang gangguan koneksi. Mohon hubungi admin via WhatsApp aja ya.']);
        }
    }
}
