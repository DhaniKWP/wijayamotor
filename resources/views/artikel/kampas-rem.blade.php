@extends('layouts.app')

@section('title', '5 Tanda Kampas Rem Mobil Anda Harus Segera Diganti — Wijaya Motor')

@section('content')
<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-danger transition">Home</a>
        <span>&rsaquo;</span>
        <a href="{{ url('/#berita') }}" class="hover:text-danger transition">Tips & Berita</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Kampas Rem</span>
    </div>
</div>

<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <p class="text-xs text-brand font-bold mb-3 uppercase tracking-wider">TIPS PERAWATAN</p>
        <h1 class="text-3xl md:text-4xl font-black text-ink leading-tight">5 Tanda Kampas Rem Mobil Anda Harus Segera Diganti</h1>
        <div class="flex items-center text-sm text-gray-400 mt-4 space-x-4">
            <span>📅 12 Juni 2026</span>
            <span>👤 Wijaya Motor</span>
        </div>
    </div>

    <img src="https://images.unsplash.com/photo-1493238792000-8113da705763?auto=format&fit=crop&w=1200&q=80" 
         alt="Kampas Rem Mobil" 
         class="w-full h-72 md:h-96 object-cover rounded-xl mb-8">

    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-5">
        <p class="text-lg font-semibold text-gray-900">Jangan abaikan bunyi berdecit saat mengerem, bisa jadi itu tanda kampas rem Anda sudah menipis dan berbahaya bagi keselamatan.</p>

        <p>Kampas rem adalah salah satu komponen vital pada sistem pengereman mobil Anda. Seiring pemakaian, kampas rem akan mengalami keausan dan pada akhirnya perlu diganti. Mengabaikan tanda-tanda kampas rem yang sudah aus bisa berakibat fatal bagi keselamatan berkendara.</p>

        <p>Berikut adalah <strong>5 tanda utama</strong> bahwa kampas rem mobil Anda sudah waktunya diganti:</p>

        <h2 class="text-xl font-bold text-ink mt-8">1. Bunyi Berdecit atau Berderit Saat Mengerem</h2>
        <p>Ini adalah tanda yang paling umum dan paling mudah dikenali. Kampas rem modern memiliki indikator keausan berupa logam kecil yang akan mengeluarkan bunyi berdecit saat kampas sudah menipis. Jika Anda mendengar suara ini saat mengerem, segera periksakan ke bengkel terpercaya.</p>

        <h2 class="text-xl font-bold text-ink mt-8">2. Pedal Rem Terasa Lebih Dalam atau Lembek</h2>
        <p>Jika Anda merasa pedal rem harus diinjak lebih dalam dari biasanya untuk mendapatkan respons pengereman yang sama, ini bisa menjadi indikasi kampas rem sudah aus. Sistem hidrolik mungkin juga bermasalah, jadi sebaiknya segera periksa.</p>

        <h2 class="text-xl font-bold text-ink mt-8">3. Getaran Saat Mengerem</h2>
        <p>Jika setir atau pedal rem bergetar saat Anda mengerem, terutama pada kecepatan tinggi, ini bisa berarti kampas rem sudah tidak rata atau cakram rem mengalami warpage. Jangan tunda untuk memeriksakannya.</p>

        <h2 class="text-xl font-bold text-ink mt-8">4. Ketebalan Kampas Kurang dari 3 mm</h2>
        <p>Anda bisa memeriksa ketebalan kampas rem secara visual melalui celah pelek. Jika ketebalannya sudah kurang dari 3 mm (sekitar seperempat inci), sudah saatnya mengganti. Mekanik biasanya akan merekomendasikan penggantian saat ketebalan mencapai 3 mm atau kurang.</p>

        <h2 class="text-xl font-bold text-ink mt-8">5. Lampu Indikator Rem Menyala</h2>
        <p>Beberapa mobil modern dilengkapi dengan sensor keausan kampas rem yang akan menyalakan lampu peringatan di dashboard. Jika lampu indikator rem menyala, jangan abaikan — segera periksakan ke bengkel.</p>

        <div class="bg-gray-50 border-l-4 border-danger p-5 rounded-r-lg mt-8">
            <p class="font-bold text-gray-900">💡 Tips dari Wijaya Motor:</p>
            <p class="mt-1 text-sm">Kami sarankan untuk memeriksa kampas rem setiap 10.000 km atau setiap 6 bulan sekali, tergantung mana yang lebih dulu. Untuk hasil terbaik, lakukan servis rem di bengkel resmi seperti Wijaya Motor.</p>
        </div>

        <p class="mt-8">Jangan tunda keselamatan Anda. Segera booking servis rem di Wijaya Motor melalui website kami dan dapatkan diskon 20% untuk servis perdana!</p>
    </div>

    <div class="mt-10 pt-8 border-t border-gray-200 flex justify-between">
        <a href="{{ url('/#berita') }}" class="text-danger font-bold hover:underline flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Artikel
        </a>
        <a href="{{ route('booking.create') }}" class="bg-danger hover:bg-red-700 text-white font-bold px-6 py-3 rounded-lg transition text-sm">
            Booking Servis Sekarang
        </a>
    </div>
</article>
@endsection