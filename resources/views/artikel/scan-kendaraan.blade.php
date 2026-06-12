@extends('layouts.app')

@section('title', 'Kini di Wijaya Motor: Scan Kendaraan Cepat & Akurat! — Wijaya Motor')

@section('content')
<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-danger transition">Home</a>
        <span>&rsaquo;</span>
        <a href="{{ url('/#berita') }}" class="hover:text-danger transition">Tips & Berita</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Scan Kendaraan</span>
    </div>
</div>

<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <p class="text-xs text-brand font-bold mb-3 uppercase tracking-wider">BERITA BENGKEL</p>
        <h1 class="text-3xl md:text-4xl font-black text-ink leading-tight">Kini di Wijaya Motor: Scan Kendaraan Cepat & Akurat!</h1>
        <div class="flex items-center text-sm text-gray-400 mt-4 space-x-4">
            <span>📅 8 Juni 2026</span>
            <span>👤 Wijaya Motor</span>
        </div>
    </div>

    <img src="https://images.unsplash.com/photo-1623682783900-fea916dcba74?auto=format&fit=crop&w=1200&q=80" 
         alt="Scan Kendaraan" 
         class="w-full h-72 md:h-96 object-cover rounded-xl mb-8">

    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-5">
        <p class="text-lg font-semibold text-gray-900">Temukan masalah pada mobil Anda sebelum menjadi kerusakan yang lebih besar dengan layanan scan kendaraan terbaru dari Wijaya Motor.</p>

        <p>Wijaya Motor dengan bangga mengumumkan kehadiran layanan <strong>Diagnostic Scan Kendaraan</strong> terbaru menggunakan alat scan generasi terbaru. Kini, teknisi kami dapat mendeteksi masalah pada mobil Anda dengan lebih cepat, akurat, dan menyeluruh.</p>

        <h2 class="text-xl font-bold text-ink mt-8">Apa Itu Diagnostic Scan Kendaraan?</h2>
        <p>Diagnostic scan atau yang sering disebut sebagai "scan ECU" adalah proses pembacaan data dari Electronic Control Unit (ECU) mobil Anda. ECU adalah "otak" dari mobil modern yang mengontrol berbagai sistem seperti mesin, transmisi, rem ABS, airbag, dan masih banyak lagi.</p>

        <p>Dengan alat scan terbaru, kami dapat membaca kode error (DTC — Diagnostic Trouble Codes) yang tersimpan di ECU, melihat data real-time dari berbagai sensor, dan melakukan analisis menyeluruh terhadap kondisi mobil Anda.</p>

        <h2 class="text-xl font-bold text-ink mt-8">Apa Saja yang Bisa Dideteksi?</h2>
        <ul class="list-disc pl-6 space-y-2">
            <li><strong>Mesin:</strong> Masalah pembakaran, sensor oksigen, knocking, misfire, hingga masalah bahan bakar</li>
            <li><strong>Transmisi:</strong> Error pada sistem perpindahan gigi, masalah kopling (pada matic), sensor kecepatan</li>
            <li><strong>Sistem Rem:</strong> ABS, sensor keausan kampas rem, masalah pada master rem</li>
            <li><strong>Sistem Kelistrikan:</strong> Alternator, aki, sensor-sensor, hingga masalah pada wiring</li>
            <li><strong>Airbag & SRS:</strong> Mendeteksi error pada sistem keselamatan pasif mobil</li>
            <li><strong>Emisi Gas Buang:</strong> Memeriksa apakah mobil Anda lolos uji emisi atau tidak</li>
        </ul>

        <h2 class="text-xl font-bold text-ink mt-8">Keunggulan Scan di Wijaya Motor</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="font-bold text-ink">🔍 Akurasi Tinggi</p>
                <p class="text-sm mt-1">Menggunakan alat scan OEM-grade yang sama dengan yang digunakan bengkel resmi.</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="font-bold text-ink">⚡ Cepat</p>
                <p class="text-sm mt-1">Proses scan hanya membutuhkan waktu 15-30 menit, hasil langsung diketahui.</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="font-bold text-ink">📋 Laporan Detail</p>
                <p class="text-sm mt-1">Anda akan mendapatkan laporan lengkap berisi kode error, artinya, dan rekomendasi perbaikan.</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="font-bold text-ink">💰 Harga Terjangkau</p>
                <p class="text-sm mt-1">Biaya scan mulai dari Rp 100.000 saja. Gratis untuk customer yang melakukan servis di tempat.</p>
            </div>
        </div>

        <div class="bg-gray-50 border-l-4 border-danger p-5 rounded-r-lg mt-8">
            <p class="font-bold text-gray-900">💡 Tips dari Wijaya Motor:</p>
            <p class="mt-1 text-sm">Lakukan scan kendaraan secara rutin setiap 6 bulan atau setiap kali Anda merasa ada keanehan pada mobil Anda. Dengan deteksi dini, Anda bisa menghemat biaya perbaikan hingga 70% dibandingkan menunggu sampai kerusakan parah.</p>
        </div>

        <p class="mt-8">Segera booking layanan scan kendaraan di Wijaya Motor dan dapatkan diskon 20% untuk servis perdana Anda!</p>
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