@extends('layouts.app')

@section('title', 'Kapan Waktu yang Tepat Mengganti Oli Gardan & Transmisi? — Wijaya Motor')

@section('content')
<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-danger transition">Home</a>
        <span>&rsaquo;</span>
        <a href="{{ url('/#berita') }}" class="hover:text-danger transition">Tips & Berita</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Oli Gardan & Transmisi</span>
    </div>
</div>

<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <p class="text-xs text-brand font-bold mb-3 uppercase tracking-wider">TIPS PERAWATAN</p>
        <h1 class="text-3xl md:text-4xl font-black text-ink leading-tight">Kapan Waktu yang Tepat Mengganti Oli Gardan & Transmisi?</h1>
        <div class="flex items-center text-sm text-gray-400 mt-4 space-x-4">
            <span>📅 10 Juni 2026</span>
            <span>👤 Wijaya Motor</span>
        </div>
    </div>

    <img src="https://images.unsplash.com/photo-1711199694531-e982a79ea381?auto=format&fit=crop&w=1200&q=80" 
         alt="Oli Gardan dan Transmisi" 
         class="w-full h-72 md:h-96 object-cover rounded-xl mb-8">

    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-5">
        <p class="text-lg font-semibold text-gray-900">Banyak pemilik mobil lupa mengganti oli gardan. Padahal, telat mengganti bisa membuat gigi gardan rontok dan biaya perbaikannya sangat mahal.</p>

        <p>Oli gardan dan oli transmisi adalah dua komponen pelumas yang sangat penting namun sering diabaikan oleh pemilik mobil. Banyak yang hanya fokus pada oli mesin, padahal kedua oli ini memiliki peran krusial dalam menjaga performa dan keawetan mobil Anda.</p>

        <h2 class="text-xl font-bold text-ink mt-8">Apa Perbedaan Oli Gardan dan Oli Transmisi?</h2>
        <p>Oli transmisi berfungsi melumasi komponen di dalam transmisi (gigi percepatan), baik transmisi manual maupun otomatis. Sementara oli gardan melumasi differential dan gigi final drive pada gardan belakang (pada mobil RWD) atau gardan depan (pada mobil FWD). Keduanya memiliki viskositas dan spesifikasi yang berbeda.</p>

        <h2 class="text-xl font-bold text-ink mt-8">Kapan Waktu yang Tepat Mengganti Oli Transmisi?</h2>
        <p>Untuk transmisi manual, umumnya oli transmisi perlu diganti setiap <strong>40.000 – 60.000 km</strong> atau setiap 2-3 tahun. Sementara untuk transmisi otomatis (matic), interval penggantian biasanya lebih sering, yaitu setiap <strong>20.000 – 40.000 km</strong> tergantung merek dan tipe mobil. Selalu cek buku manual mobil Anda untuk rekomendasi yang lebih akurat.</p>

        <h2 class="text-xl font-bold text-ink mt-8">Kapan Waktu yang Tepat Mengganti Oli Gardan?</h2>
        <p>Oli gardan umumnya memiliki interval penggantian yang lebih panjang, yaitu sekitar <strong>40.000 – 80.000 km</strong>. Namun, untuk mobil yang sering digunakan untuk off-road atau membawa beban berat, intervalnya bisa lebih pendek. Tanda-tanda oli gardan perlu diganti antara lain:</p>
        <ul class="list-disc pl-6 space-y-2">
            <li>Muncul bunyi dengung (humming) dari bagian gardan saat melaju</li>
            <li>Kebocoran oli gardan (tanda basah di sekitar rumah gardan)</li>
            <li>Getaran tidak normal dari bagian belakang mobil</li>
            <li>Oli gardan berwarna hitam pekat atau mengandung serpihan logam</li>
        </ul>

        <h2 class="text-xl font-bold text-ink mt-8">Apa Akibatnya Jika Telat Mengganti?</h2>
        <p>Telat mengganti oli gardan dan transmisi bisa menyebabkan:</p>
        <ul class="list-disc pl-6 space-y-2">
            <li>Gigi-gigi di dalam gardan atau transmisi mengalami keausan parah</li>
            <li>Overheating pada komponen akibat pelumasan yang tidak memadai</li>
            <li>Gigi gardan rontok (patah) yang membutuhkan penggantian total gardan</li>
            <li>Biaya perbaikan yang sangat mahal, bisa mencapai puluhan juta rupiah</li>
        </ul>

        <div class="bg-gray-50 border-l-4 border-danger p-5 rounded-r-lg mt-8">
            <p class="font-bold text-gray-900">💡 Tips dari Wijaya Motor:</p>
            <p class="mt-1 text-sm">Kami sarankan untuk memeriksa kondisi oli gardan dan transmisi bersamaan dengan servis rutin mobil Anda. Di Wijaya Motor, kami menyediakan layanan penggantian oli gardan dan transmisi dengan harga terjangkau dan garansi.</p>
        </div>

        <p class="mt-8">Jangan menunggu sampai rusak. Segera booking servis Anda di Wijaya Motor dan dapatkan diskon 20% untuk servis perdana melalui website!</p>
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