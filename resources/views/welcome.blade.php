<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Wijaya Motor — Bengkel Terpercaya Jakarta</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
        colors: {
          brand: { DEFAULT: '#E84B1A', dark: '#c73f13' },
          ink: { DEFAULT: '#111827', light: '#1f2937' },
        }
      }
    }
  }
</script>
<style>
  * { font-family: 'Plus Jakarta Sans', sans-serif; }
  html { scroll-behavior: smooth; }
  .hero-bg {
    background: #111827;
    background-image: radial-gradient(ellipse at 70% 50%, rgba(232,75,26,0.08) 0%, transparent 60%);
  }
  .ticker-wrap { overflow: hidden; }
  .ticker-track {
    display: flex; white-space: nowrap;
    animation: ticker 20s linear infinite;
  }
  @keyframes ticker { from { transform: translateX(0); } to { transform: translateX(-50%); } }
  .card-hover { transition: all 0.25s ease; }
  .card-hover:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,0.12); }
  .nav-scroll { transition: box-shadow 0.3s; }
</style>
</head>
<body class="bg-white text-gray-900 antialiased">

<!-- ============================================================ NAV -->
<nav id="navbar" class="fixed top-0 inset-x-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100 nav-scroll">
  <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
    <a href="#" class="flex items-center gap-2">
      <span class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center">
        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L4 6v6c0 5.5 3.5 10.7 8 12 4.5-1.3 8-6.5 8-12V6l-8-4z"/></svg>
      </span>
      <span class="font-bold text-lg text-gray-900">Wijaya <span class="text-brand">Motor</span></span>
    </a>
    <div class="hidden md:flex items-center gap-8">
      <a href="#cara-booking" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Cara Booking</a>
      <a href="#layanan" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Layanan</a>
      <a href="#sparepart" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Sparepart</a>
      <a href="#kontak" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Kontak</a>
    </div>
    <div class="flex items-center gap-3">
      <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors px-4 py-2">Masuk</a>
      <a href="{{ route('register') }}" class="text-sm font-semibold bg-brand hover:bg-brand-dark text-white px-5 py-2.5 rounded-lg transition-colors">Daftar Gratis</a>
    </div>
  </div>
</nav>

<!-- ============================================================ HERO -->
<section class="hero-bg min-h-screen flex items-center pt-16">
  <div class="max-w-6xl mx-auto px-6 py-24 grid md:grid-cols-2 gap-16 items-center">
    <!-- Left -->
    <div>
      <span class="inline-flex items-center gap-2 bg-brand/10 text-brand text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-6">
        <span class="w-1.5 h-1.5 bg-brand rounded-full animate-pulse"></span>
        Booking Online Tersedia
      </span>
      <h1 class="text-5xl md:text-6xl font-extrabold text-white leading-tight mb-6">
        Servis Mobil<br>
        <span class="text-brand">Tanpa Antre,</span><br>
        <span class="text-gray-400 font-light">Kapan Saja.</span>
      </h1>
      <p class="text-gray-400 text-lg leading-relaxed mb-8 max-w-md">
        Mekanik tersertifikasi siap menangani kendaraan Anda. Jadwalkan servis dari rumah — cukup beberapa klik, tiket QR langsung di tangan.
      </p>
      <div class="flex flex-wrap gap-4 mb-12">
        <a href="{{ route('booking.create') }}" class="flex items-center gap-2 bg-brand hover:bg-brand-dark text-white font-bold px-8 py-4 rounded-xl text-sm transition-all hover:scale-105 shadow-lg shadow-brand/30">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
          Booking Sekarang
        </a>
        <a href="#layanan" class="flex items-center gap-2 border border-gray-600 text-gray-300 hover:border-white hover:text-white font-semibold px-8 py-4 rounded-xl text-sm transition-all">
          Lihat Layanan
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <!-- Stats -->
      <div class="flex gap-8 pt-8 border-t border-gray-700">
        <div>
          <div class="text-3xl font-extrabold text-white">500<span class="text-brand">+</span></div>
          <div class="text-xs text-gray-500 font-medium mt-1">Servis Selesai</div>
        </div>
        <div>
          <div class="text-3xl font-extrabold text-white">100<span class="text-brand">%</span></div>
          <div class="text-xs text-gray-500 font-medium mt-1">Sparepart Asli</div>
        </div>
        <div>
          <div class="text-3xl font-extrabold text-white">★<span class="text-brand"> 4.9</span></div>
          <div class="text-xs text-gray-500 font-medium mt-1">Rating Pelanggan</div>
        </div>
      </div>
    </div>
    <!-- Right: Info cards -->
    <div class="hidden md:grid grid-cols-2 gap-4">
      <div class="bg-gray-800/60 border border-gray-700 rounded-2xl p-6 card-hover">
        <div class="w-10 h-10 bg-brand/15 rounded-xl flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div class="text-white font-bold mb-1">Mekanik Bersertifikat</div>
        <div class="text-gray-400 text-sm">Teknisi terlatih & berpengalaman</div>
      </div>
      <div class="bg-gray-800/60 border border-gray-700 rounded-2xl p-6 card-hover mt-6">
        <div class="w-10 h-10 bg-brand/15 rounded-xl flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <div class="text-white font-bold mb-1">Booking Online</div>
        <div class="text-gray-400 text-sm">Pilih jadwal & tiket QR otomatis</div>
      </div>
      <div class="bg-brand rounded-2xl p-6 card-hover">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <div class="text-white font-bold mb-1">Buka 6 Hari</div>
        <div class="text-white/70 text-sm">Senin–Sabtu, 08.00–18.00</div>
      </div>
      <div class="bg-gray-800/60 border border-gray-700 rounded-2xl p-6 card-hover mt-6">
        <div class="w-10 h-10 bg-brand/15 rounded-xl flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <div class="text-white font-bold mb-1">Sparepart Asli</div>
        <div class="text-gray-400 text-sm">50+ produk berkualitas tersedia</div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ TICKER -->
<div class="bg-brand ticker-wrap py-3">
  <div class="ticker-track">
    @foreach(['Ganti Oli Mesin','Service Tune Up','Kaki-kaki','Cek AC','Balancing & Spooring','Sparepart Asli','Booking Online 24 Jam','Tiket QR Code','Ganti Oli Mesin','Service Tune Up','Kaki-kaki','Cek AC','Balancing & Spooring','Sparepart Asli','Booking Online 24 Jam','Tiket QR Code'] as $item)
    <span class="flex items-center gap-3 px-8 text-white text-xs font-bold uppercase tracking-widest">
      <span class="w-1 h-1 bg-white/50 rounded-full"></span>{{ $item }}
    </span>
    @endforeach
  </div>
</div>

<!-- ============================================================ CARA BOOKING -->
<section id="cara-booking" class="py-24 bg-gray-50">
  <div class="max-w-6xl mx-auto px-6">
    <div class="text-center mb-16">
      <span class="text-brand text-sm font-bold uppercase tracking-widest">Mudah & Cepat</span>
      <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-3">Booking dalam 4 Langkah</h2>
      <p class="text-gray-500 mt-4 max-w-lg mx-auto">Tanpa telepon, tanpa antre. Semua diatur dari smartphone Anda.</p>
    </div>
    <div class="grid md:grid-cols-4 gap-6">
      <!-- Step 1 -->
      <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm card-hover relative">
        <div class="absolute -top-3 -right-3 w-8 h-8 bg-brand text-white text-xs font-black rounded-full flex items-center justify-center">1</div>
        <div class="w-12 h-12 bg-brand/10 rounded-xl flex items-center justify-center mb-5">
          <svg class="w-6 h-6 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <h3 class="font-bold text-gray-900 mb-2">Buat Akun</h3>
        <p class="text-gray-500 text-sm leading-relaxed">Daftar gratis, hanya butuh email dan nomor HP Anda.</p>
      </div>
      <!-- Step 2 -->
      <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm card-hover relative">
        <div class="absolute -top-3 -right-3 w-8 h-8 bg-gray-200 text-gray-600 text-xs font-black rounded-full flex items-center justify-center">2</div>
        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mb-5">
          <svg class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><path d="M3 17l4 4L12 14"/></svg>
        </div>
        <h3 class="font-bold text-gray-900 mb-2">Daftarkan Kendaraan</h3>
        <p class="text-gray-500 text-sm leading-relaxed">Tambahkan data mobil Anda untuk booking lebih cepat ke depannya.</p>
      </div>
      <!-- Step 3 -->
      <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm card-hover relative">
        <div class="absolute -top-3 -right-3 w-8 h-8 bg-gray-200 text-gray-600 text-xs font-black rounded-full flex items-center justify-center">3</div>
        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mb-5">
          <svg class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <h3 class="font-bold text-gray-900 mb-2">Pilih Jadwal & Layanan</h3>
        <p class="text-gray-500 text-sm leading-relaxed">Tentukan tanggal, jam, dan jenis servis. Estimasi harga langsung terlihat.</p>
      </div>
      <!-- Step 4 -->
      <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm card-hover relative">
        <div class="absolute -top-3 -right-3 w-8 h-8 bg-gray-200 text-gray-600 text-xs font-black rounded-full flex items-center justify-center">4</div>
        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mb-5">
          <svg class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h3 class="font-bold text-gray-900 mb-2">Tunjukkan QR Code</h3>
        <p class="text-gray-500 text-sm leading-relaxed">Datang sesuai jadwal, scan QR di meja admin — langsung dilayani.</p>
      </div>
    </div>
    <div class="text-center mt-10">
      <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-brand hover:bg-brand-dark text-white font-bold px-8 py-4 rounded-xl text-sm transition-all hover:scale-105 shadow-lg shadow-brand/20">
        Mulai Sekarang — Gratis
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- ============================================================ LAYANAN -->
<section id="layanan" class="py-24 bg-white">
  <div class="max-w-6xl mx-auto px-6">
    <div class="mb-12">
      <span class="text-brand text-sm font-bold uppercase tracking-widest">Layanan Profesional</span>
      <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-3">Semua Kebutuhan<br>Kendaraan Anda</h2>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      <!-- Tune Up - Featured -->
      <div class="bg-ink rounded-2xl p-8 relative overflow-hidden card-hover md:row-span-1">
        <span class="absolute top-4 right-4 bg-brand text-white text-xs font-bold px-3 py-1 rounded-full">Best Seller</span>
        <div class="w-12 h-12 bg-brand/20 rounded-xl flex items-center justify-center mb-6">
          <svg class="w-6 h-6 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
        </div>
        <div class="text-xs font-bold text-brand uppercase tracking-widest mb-3">Paling Diminati</div>
        <h3 class="text-2xl font-extrabold text-white mb-3">Service Tune Up</h3>
        <p class="text-gray-400 text-sm leading-relaxed mb-6">Penyetelan mesin komprehensif, pembersihan injektor, dan pengecekan sistem kelistrikan agar performa mobil kembali prima.</p>
        <div class="flex items-end justify-between">
          <div>
            <div class="text-xs text-gray-500 mb-1">Est. Harga Dasar</div>
            <div class="text-2xl font-extrabold text-white">Rp 100.000</div>
          </div>
          <a href="{{ route('booking.create') }}" class="w-10 h-10 bg-brand rounded-xl flex items-center justify-center hover:bg-brand-dark transition-colors">
            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>

      <!-- Ganti Oli -->
      <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8 card-hover">
        <div class="w-12 h-12 bg-brand/10 rounded-xl flex items-center justify-center mb-6">
          <svg class="w-6 h-6 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 5H5l-2 14h18L19 5z"/><path d="M12 9v6M9 12h6"/></svg>
        </div>
        <div class="text-xs font-bold text-brand uppercase tracking-widest mb-3">Rutin</div>
        <h3 class="text-xl font-extrabold text-gray-900 mb-3">Ganti Oli Mesin</h3>
        <p class="text-gray-500 text-sm leading-relaxed mb-6">Penggantian pelumas sintetis berkualitas tinggi untuk menjaga suhu mesin dan memperpanjang usia mesin kendaraan Anda.</p>
        <div class="flex items-end justify-between">
          <div>
            <div class="text-xs text-gray-400 mb-1">Est. Harga Dasar</div>
            <div class="text-xl font-extrabold text-gray-900">Rp 50.000</div>
          </div>
          <a href="{{ route('booking.create') }}" class="w-10 h-10 border border-gray-200 rounded-xl flex items-center justify-center hover:bg-brand hover:border-brand group transition-all">
            <svg class="w-4 h-4 text-gray-700 group-hover:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>

      <!-- Kaki-kaki -->
      <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8 card-hover">
        <div class="w-12 h-12 bg-brand/10 rounded-xl flex items-center justify-center mb-6">
          <svg class="w-6 h-6 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="5" cy="17" r="3"/><circle cx="19" cy="17" r="3"/><path d="M5 14V9l5-2h4l5 3v4"/></svg>
        </div>
        <div class="text-xs font-bold text-brand uppercase tracking-widest mb-3">Suspensi</div>
        <h3 class="text-xl font-extrabold text-gray-900 mb-3">Service Kaki-kaki</h3>
        <p class="text-gray-500 text-sm leading-relaxed mb-6">Pengecekan suspensi, shockbreaker, tie rod, hingga balancing untuk kenyamanan dan keamanan berkendara optimal.</p>
        <div class="flex items-end justify-between">
          <div>
            <div class="text-xs text-gray-400 mb-1">Est. Harga Dasar</div>
            <div class="text-xl font-extrabold text-gray-900">Rp 900.000</div>
          </div>
          <a href="{{ route('booking.create') }}" class="w-10 h-10 border border-gray-200 rounded-xl flex items-center justify-center hover:bg-brand hover:border-brand group transition-all">
            <svg class="w-4 h-4 text-gray-700 group-hover:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>
    </div>
    <p class="text-gray-400 text-xs mt-4">* Estimasi jasa dasar, belum termasuk penggantian suku cadang tambahan.</p>

    <!-- CTA Banner -->
    <div class="mt-10 bg-gray-50 border border-gray-100 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-6">
      <div>
        <div class="font-bold text-gray-900 text-lg">Ada kebutuhan servis lainnya?</div>
        <div class="text-gray-500 text-sm mt-1">Hubungi kami langsung atau cek ketersediaan jadwal di booking online.</div>
      </div>
      <div class="flex gap-3 shrink-0">
        <a href="https://wa.me/622155500199" target="_blank" class="flex items-center gap-2 border border-gray-200 text-gray-700 hover:border-brand hover:text-brand font-semibold px-5 py-3 rounded-xl text-sm transition-all">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          WhatsApp
        </a>
        <a href="{{ route('booking.create') }}" class="flex items-center gap-2 bg-brand hover:bg-brand-dark text-white font-bold px-5 py-3 rounded-xl text-sm transition-all">
          Booking Sekarang
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ SPAREPART -->
<section id="sparepart" class="py-24 bg-gray-50">
  <div class="max-w-6xl mx-auto px-6">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
      <div>
        <span class="text-brand text-sm font-bold uppercase tracking-widest">Etalase Toko</span>
        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-3">Sparepart Asli<br>Terjamin Kualitasnya</h2>
      </div>
      <a href="#" class="flex items-center gap-2 text-brand font-bold text-sm hover:underline shrink-0">
        Lihat Semua Katalog →
      </a>
    </div>
    <div class="grid md:grid-cols-4 gap-5">
      <!-- Part 1 -->
      <div class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover border border-gray-100">
        <div class="h-44 overflow-hidden bg-gray-100">
          <img src="https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?auto=format&fit=crop&w=400&q=80" alt="Oli" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-5">
          <span class="text-brand text-xs font-bold uppercase tracking-wider">Oli & Cairan</span>
          <h4 class="font-bold text-gray-900 mt-1 mb-1">Elite Synthetic 5W-30</h4>
          <p class="text-gray-400 text-xs mb-3">Pelumas mesin mobil premium</p>
          <div class="font-extrabold text-gray-900">Rp 150.000</div>
        </div>
      </div>
      <!-- Part 2 -->
      <div class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover border border-gray-100">
        <div class="h-44 overflow-hidden bg-gray-100">
          <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=400&q=80" alt="Filter" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-5">
          <span class="text-brand text-xs font-bold uppercase tracking-wider">Suku Cadang</span>
          <h4 class="font-bold text-gray-900 mt-1 mb-1">Filter Udara Ori</h4>
          <p class="text-gray-400 text-xs mb-3">Penyaring debu & kotoran mesin</p>
          <div class="font-extrabold text-gray-900">Rp 85.000</div>
        </div>
      </div>
      <!-- Part 3 -->
      <div class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover border border-gray-100">
        <div class="h-44 overflow-hidden bg-gray-100">
          <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=400&q=80" alt="Busi" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-5">
          <span class="text-brand text-xs font-bold uppercase tracking-wider">Pengapian</span>
          <h4 class="font-bold text-gray-900 mt-1 mb-1">Busi Iridium NGK</h4>
          <p class="text-gray-400 text-xs mb-3">Sistem pengapian optimal</p>
          <div class="font-extrabold text-gray-900">Rp 120.000</div>
        </div>
      </div>
      <!-- Card CTA -->
      <div class="bg-ink rounded-2xl p-6 flex flex-col justify-between card-hover">
        <div>
          <div class="text-4xl font-extrabold text-white/10 mb-2">50+</div>
          <div class="text-white font-bold text-lg mb-2">Produk Tersedia</div>
          <p class="text-gray-400 text-sm">Jelajahi katalog lengkap sparepart asli kami</p>
        </div>
        <a href="#" class="mt-6 bg-brand hover:bg-brand-dark text-white text-sm font-bold px-5 py-3 rounded-xl text-center transition-colors">
          Lihat Semua →
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ KONTAK / INFO -->
<section id="kontak" class="py-24 bg-ink">
  <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
    <div>
      <span class="text-brand text-sm font-bold uppercase tracking-widest">Temukan Kami</span>
      <h2 class="text-4xl font-extrabold text-white mt-3 mb-6">Datang Langsung<br>atau Booking Online</h2>
      <div class="space-y-5">
        <div class="flex items-start gap-4">
          <div class="w-10 h-10 bg-brand/15 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <div>
            <div class="text-white font-semibold">Alamat</div>
            <div class="text-gray-400 text-sm mt-0.5">Jl. Sudirman No. 123, Jakarta Selatan</div>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <div class="w-10 h-10 bg-brand/15 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8 19.79 19.79 0 01.12 1.19 2 2 0 012.1 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.93l-.08 1.99z"/></svg>
          </div>
          <div>
            <div class="text-white font-semibold">Telepon</div>
            <div class="text-gray-400 text-sm mt-0.5">+62 21 555 0199</div>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <div class="w-10 h-10 bg-brand/15 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
          </div>
          <div>
            <div class="text-white font-semibold">Jam Operasional</div>
            <div class="text-gray-400 text-sm mt-0.5">Senin – Sabtu: 08.00 – 18.00 WIB</div>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <div class="w-10 h-10 bg-brand/15 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <div>
            <div class="text-white font-semibold">Email</div>
            <div class="text-gray-400 text-sm mt-0.5">admin@wijayamotor.com</div>
          </div>
        </div>
      </div>
    </div>
    <!-- Quick Booking CTA -->
    <div class="bg-gray-800/60 border border-gray-700 rounded-2xl p-10 text-center">
      <div class="w-16 h-16 bg-brand/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8 text-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
      </div>
      <h3 class="text-2xl font-extrabold text-white mb-3">Siap Booking?</h3>
      <p class="text-gray-400 text-sm mb-8 leading-relaxed">Jadwalkan servis sekarang dan dapatkan tiket QR Code langsung di email Anda.</p>
      <a href="{{ route('booking.create') }}" class="w-full flex items-center justify-center gap-2 bg-brand hover:bg-brand-dark text-white font-bold py-4 px-8 rounded-xl text-sm transition-all hover:scale-105 shadow-lg shadow-brand/30 mb-4">
        Booking Sekarang — Gratis
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
      <a href="{{ route('login') }}" class="block text-gray-500 hover:text-white text-sm transition-colors">Sudah punya akun? Masuk</a>
    </div>
  </div>
</section>

<!-- ============================================================ FOOTER -->
<footer class="bg-gray-900 border-t border-gray-800 py-12">
  <div class="max-w-6xl mx-auto px-6">
    <div class="grid md:grid-cols-4 gap-10 mb-12">
      <div class="md:col-span-2">
        <div class="flex items-center gap-2 mb-4">
          <span class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L4 6v6c0 5.5 3.5 10.7 8 12 4.5-1.3 8-6.5 8-12V6l-8-4z"/></svg>
          </span>
          <span class="font-bold text-lg text-white">Wijaya <span class="text-brand">Motor</span></span>
        </div>
        <p class="text-gray-500 text-sm leading-relaxed max-w-xs">Bengkel mobil profesional dan terpercaya di Jakarta. Mekanik tersertifikasi, sparepart asli, booking online mudah.</p>
      </div>
      <div>
        <div class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-4">Layanan</div>
        <div class="space-y-3">
          <a href="{{ route('booking.create') }}" class="block text-gray-500 hover:text-white text-sm transition-colors">Booking Servis</a>
          <a href="#layanan" class="block text-gray-500 hover:text-white text-sm transition-colors">Service Tune Up</a>
          <a href="#layanan" class="block text-gray-500 hover:text-white text-sm transition-colors">Ganti Oli</a>
          <a href="#layanan" class="block text-gray-500 hover:text-white text-sm transition-colors">Service Kaki-kaki</a>
          <a href="#sparepart" class="block text-gray-500 hover:text-white text-sm transition-colors">Katalog Sparepart</a>
        </div>
      </div>
      <div>
        <div class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-4">Akun</div>
        <div class="space-y-3">
          <a href="{{ route('login') }}" class="block text-gray-500 hover:text-white text-sm transition-colors">Masuk</a>
          <a href="{{ route('register') }}" class="block text-gray-500 hover:text-white text-sm transition-colors">Daftar Gratis</a>
          <a href="{{ route('dashboard') }}" class="block text-gray-500 hover:text-white text-sm transition-colors">Dashboard</a>
        </div>
      </div>
    </div>
    <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
      <span class="text-gray-600 text-xs">© 2026 Wijaya Motor. All rights reserved.</span>
      <span class="text-gray-600 text-xs">Dibuat dengan ❤ untuk pelanggan Jakarta</span>
    </div>
  </div>
</footer>

<script>
  // Nav shadow on scroll
  const navbar = document.getElementById('navbar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
      navbar.classList.add('shadow-md');
    } else {
      navbar.classList.remove('shadow-md');
    }
  });
</script>
</body>
</html>