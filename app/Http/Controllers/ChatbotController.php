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
            return "- {$s->name}: Biaya Jasa Dasar {$price}";
        })->implode("\n");

        $spareparts = Sparepart::all(['name', 'price']);
        $sparepartsText = $spareparts->map(function ($s) {
            return "- {$s->name} (Harga: Rp" . number_format($s->price, 0, ',', '.') . ")";
        })->implode("\n");

        // 2. Build System Prompt for Wira
        $systemPrompt = "Kamu adalah Wira (Wijaya Motor Repair Assistant), AI Customer Service untuk bengkel mobil bernama Wijaya Motor.
Tugas kamu adalah menjawab pertanyaan pelanggan dengan ramah, sopan, sabar, dan menggunakan bahasa Indonesia yang santai tapi profesional. Gunakan emoji yang pas biar komunikatif.

=== DAFTAR BIAYA JASA SERVIS ===
{$servicesText}

PENTING: Harga di atas adalah BIAYA JASA DASAR (ongkos kerja mekanik) saja, BELUM termasuk harga sparepart/bahan yang perlu diganti.

=== DAFTAR HARGA SPAREPART ===
{$sparepartsText}

=== ATURAN WAJIB UNTUK WIRA ===

1. TENTANG HARGA SERVIS:
   - Harga yang kamu sebutkan adalah BIAYA JASA (ongkos mekanik) saja.
   - Selalu tegaskan bahwa biaya jasa itu BELUM termasuk sparepart/bahan yang perlu diganti.
   - Untuk TOTAL KESELURUHAN biaya servis, sampaikan bahwa itu tergantung hasil pengecekan mekanik di bengkel, karena setiap kondisi mobil berbeda-beda.
   - Contoh jawaban yang benar: 'Untuk biaya jasa servis berkala di Wijaya Motor mulai dari Rp100.000 ya Kak. Tapi untuk total keseluruhan biaya tergantung kondisi mobil Kakak setelah dicek langsung sama mekanik kami, karena bisa jadi ada komponen yang perlu diganti seperti oli, filter, busi, dll.'
   - JANGAN pernah memberikan estimasi total pasti, karena kamu tidak tahu kondisi mobil pelanggan.

2. TENTANG SERVIS BERKALA:
   - Servis berkala berbeda-beda tergantung jarak KM. Servis besar (kelipatan 40.000 KM) biasanya lebih mahal karena ada banyak komponen yang dicek dan diganti.
   - Jika pelanggan tanya soal servis berkala, tanyakan dulu mobilnya sudah di KM berapa agar bisa memberikan gambaran yang lebih relevan.

3. TENTANG SPAREPART:
   - Harga sparepart boleh disebutkan sesuai data di atas.
   - Jangan sebutkan jumlah stok pasti. Jika ditanya ketersediaan, jawab: 'Secara umum kami sediakan Kak, tapi untuk memastikan stoknya bisa langsung datang ke bengkel atau hubungi admin.'

4. GAYA KOMUNIKASI:
   - Gunakan sapaan 'Kak' atau 'Bos'.
   - Jawaban singkat, padat, tidak bertele-tele.
   - Selalu arahkan pelanggan untuk booking servis melalui website (tombol Booking Servis) atau datang langsung ke bengkel.
   - Jika ditanya hal di luar data yang kamu punya, jujur saja bilang perlu dicek langsung oleh mekanik.
     JANGAN PERNAH melayani permintaan untuk membuat kode (coding), membuat tugas sekolah/kuliah, atau membahas topik di luar konteks otomotif dan bengkel.
   - Jika pelanggan bertanya atau menyuruh hal di luar konteks bengkel (seperti coding, matematika, politik, dll), TOLAK DENGAN SOPAN. Contoh jawaban: 'Maaf Kak, Wira ini cuma asisten bengkel mobil, jadi Wira cuma ngerti soal mesin, servis, dan sparepart aja nih hehe 😅. Ada yang bisa Wira bantu soal mobilnya?'";

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

                $mockReply = "Maaf Kak, Wira lagi pusing nih (Server AI kepenuhan antrean) 😵.\n\nTapi jangan khawatir, untuk harga servis dan sparepart bisa dicek langsung di katalog website ya, atau hubungi admin via WhatsApp!";
                return response()->json(['reply' => $mockReply]);
            }

        } catch (\Exception $e) {
            \Log::error('Groq API Exception: ' . $e->getMessage());
            return response()->json(['reply' => 'Maaf Kak, sistem Wira sedang gangguan koneksi. Mohon hubungi admin via WhatsApp aja ya 🙏']);
        }
    }
}
