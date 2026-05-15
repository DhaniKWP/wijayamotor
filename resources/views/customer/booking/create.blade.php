<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Servis Layanan Bengkel - Wijaya Motor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#FF8C00', dark: '#e67e00', light: '#fff4e6' }, 
                        ink: { DEFAULT: '#0A192F', light: '#112a4f' },
                        surface: '#F8FAFC',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        [x-cloak] { display: none !important; }
        .radio-custom:checked + div { border-color: #FF8C00; background-color: #fff4e6; }
        .radio-custom:checked + div .radio-circle { border-color: #FF8C00; }
        .radio-custom:checked + div .radio-circle::after { transform: scale(1); }
        .checkbox-custom:checked + div { border-color: #FF8C00; background-color: #fff4e6; }
    </style>
</head>
<body class="text-gray-800 antialiased pb-32" 
      x-data="{ 
          vehicleSelected: '', 
          serviceType: 'berkala', 
          kmSelected: '1000',
          showDetailModal: false,
          detailTab: 'diperiksa',
          addonSpooring: false,
          addonAC: false,
          addonEngine: false,
          branch: '',
          date: '',
          time: '',
          get totalPrice() {
              let total = 0;
              if(this.serviceType === 'berkala') {
                  total += (this.kmSelected === '1000' ? 0 : 850000); // Contoh logika harga
              }
              if(this.addonSpooring) total += 250000;
              if(this.addonAC) total += 350000;
              if(this.addonEngine) total += 400000;
              return total;
          },
          get formattedPrice() {
              return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(this.totalPrice);
          }
      }">

<nav class="bg-white sticky top-0 z-40 shadow-sm border-b border-gray-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
        <a href="{{ url('/') }}" class="flex items-center gap-2">
            <span class="font-black text-2xl tracking-tighter text-ink">WIJAYA<span class="text-brand border-b-4 border-brand leading-none inline-block pb-0.5 ml-1">MOTOR</span></span>
        </a>
        <div class="hidden md:flex items-center space-x-6 text-sm font-bold text-gray-600">
            <a href="#" class="hover:text-brand transition">HUBUNGI KAMI</a>
            <a href="{{ route('dashboard') }}" class="flex items-center text-ink hover:text-brand transition">
                <svg class="w-5 h-5 mr-2 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                {{ Auth::user()->name }}
            </a>
        </div>
    </div>
</nav>

<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-brand">Home</a>
        <span>&rsaquo;</span>
        <a href="{{ route('dashboard') }}" class="hover:text-brand">Booking Servis</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Booking Servis Layanan Bengkel</span>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-black text-ink mb-2">Booking Servis Layanan Bengkel</h1>
    <p class="text-gray-500 mb-8">Layanan purna jual dari Wijaya Motor yang menawarkan jasa perbaikan berupa servis perawatan berkala.</p>
    
    <div class="w-full h-48 md:h-80 bg-gray-200 rounded-2xl overflow-hidden relative mb-12 shadow-sm border border-gray-200">
        <img src="https://images.unsplash.com/photo-1613214149922-f1809c99b414?auto=format&fit=crop&w=1200&q=80" alt="Banner Servis" class="w-full h-full object-cover opacity-90">
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent flex items-end p-8">
            <h2 class="text-white font-bold text-2xl drop-shadow-md">Servis Berkala & Umum</h2>
        </div>
    </div>

    <form action="{{ route('booking.store') }}" method="POST" class="max-w-3xl space-y-12 pb-10">
        @csrf

        <section>
            <h3 class="text-lg font-black text-ink uppercase tracking-tight mb-4 border-b-2 border-brand inline-block pb-1">INFORMASI PELANGGAN</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" value="{{ Auth::user()->name }}" readonly class="w-full bg-gray-100 border border-gray-300 text-gray-500 rounded-lg px-4 py-3 text-sm focus:outline-none cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email / Kontak <span class="text-red-500">*</span></label>
                    <input type="text" value="{{ Auth::user()->email }}" readonly class="w-full bg-gray-100 border border-gray-300 text-gray-500 rounded-lg px-4 py-3 text-sm focus:outline-none cursor-not-allowed">
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">*Data pelanggan ditarik otomatis dari profil akun Anda.</p>
        </section>

        <section>
            <h3 class="text-lg font-black text-ink uppercase tracking-tight mb-2 border-b-2 border-brand inline-block pb-1">INFORMASI MOBIL</h3>
            <p class="text-sm text-gray-500 mb-6">Pilih kendaraan dari garasi Anda yang ingin diperbaiki.</p>

            @if($vehicles->isEmpty())
                <div class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
                    <div class="w-12 h-12 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h4 class="font-bold text-red-700 mb-1">Garasi Kosong!</h4>
                    <p class="text-sm text-red-600 mb-4">Anda harus mendaftarkan mobil terlebih dahulu sebelum melakukan booking.</p>
                    <a href="{{ route('garasi.index') }}" class="inline-block bg-ink text-white font-bold px-6 py-2.5 rounded-lg text-sm hover:bg-ink-light transition">
                        + Tambah Mobil Sekarang
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($vehicles as $index => $vehicle)
                    <label class="relative cursor-pointer">
                        <input type="radio" name="vehicle_id" value="{{ $vehicle->id }}" class="peer sr-only radio-custom" x-model="vehicleSelected" required>
                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-brand/50 transition-colors bg-white">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="font-bold text-ink text-lg">{{ $vehicle->name }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">Tahun: {{ $vehicle->year }}</p>
                                    <div class="mt-3 inline-block bg-gray-100 text-ink font-bold text-xs px-2 py-1 rounded">
                                        {{ $vehicle->plate_number }}
                                    </div>
                                </div>
                                <div class="radio-circle w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center relative transition-colors">
                                    <div class="w-2.5 h-2.5 bg-brand rounded-full scale-0 transition-transform duration-200" style="content:'';"></div>
                                </div>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            @endif
        </section>

        <section :class="!vehicleSelected ? 'opacity-50 pointer-events-none' : ''">
            <h3 class="text-lg font-black text-ink uppercase tracking-tight mb-2 border-b-2 border-brand inline-block pb-1">PILIH JENIS SERVIS</h3>
            <p class="text-sm text-gray-500 mb-6">Pilih layanan yang diperlukan untuk mobil Anda.</p>

            <div class="space-y-4">
                <label class="relative cursor-pointer block">
                    <input type="radio" name="service_category" value="berkala" class="peer sr-only radio-custom" x-model="serviceType">
                    <div class="border-2 border-gray-200 rounded-xl p-5 hover:border-brand/50 transition-colors bg-white flex items-start">
                        <div class="radio-circle w-5 h-5 rounded-sm border-2 border-gray-300 flex items-center justify-center mt-0.5 mr-4 transition-colors">
                            <div class="w-2.5 h-2.5 bg-brand rounded-sm scale-0 transition-transform duration-200"></div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-ink text-lg">Servis Berkala</h4>
                            <p class="text-sm text-brand font-semibold mt-1 hover:underline inline-block" @click.prevent="showDetailModal = true">Lihat Detail</p>
                            
                            <div x-show="serviceType === 'berkala'" x-collapse class="mt-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Jarak Tempuh (KM)</label>
                                <select name="km_service" x-model="kmSelected" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
                                    <option value="1000">Servis Berkala Ke-1 (1.000 KM) - Rp 0 (Gratis Jasa)</option>
                                    <option value="10000">Servis Berkala Ke-2 (10.000 KM) - Rp 850.000</option>
                                    <option value="20000">Servis Berkala Ke-3 (20.000 KM) - Rp 1.100.000</option>
                                </select>
                            </div>

                            <div x-show="serviceType === 'berkala'" x-collapse class="mt-6">
                                <p class="text-sm font-bold text-gray-700 mb-3">Anda dapat memilih Pekerjaan Servis Tambahan:</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="addons[]" value="spooring" x-model="addonSpooring" class="w-5 h-5 rounded border-gray-300 text-brand focus:ring-brand accent-brand">
                                        <span class="ml-3 text-sm text-gray-700 font-medium">Spooring & Balancing</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="addons[]" value="ac" x-model="addonAC" class="w-5 h-5 rounded border-gray-300 text-brand focus:ring-brand accent-brand">
                                        <span class="ml-3 text-sm text-gray-700 font-medium">AC Superlight Care</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="addons[]" value="engine" x-model="addonEngine" class="w-5 h-5 rounded border-gray-300 text-brand focus:ring-brand accent-brand">
                                        <span class="ml-3 text-sm text-gray-700 font-medium">Engine Room Treatment</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>

                <label class="relative cursor-pointer block">
                    <input type="radio" name="service_category" value="lainnya" class="peer sr-only radio-custom" x-model="serviceType">
                    <div class="border-2 border-gray-200 rounded-xl p-5 hover:border-brand/50 transition-colors bg-white flex items-start">
                        <div class="radio-circle w-5 h-5 rounded-sm border-2 border-gray-300 flex items-center justify-center mt-0.5 mr-4 transition-colors">
                            <div class="w-2.5 h-2.5 bg-brand rounded-sm scale-0 transition-transform duration-200"></div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-ink text-lg">Servis Lainnya / Keluhan Bebas</h4>
                            
                            <div x-show="serviceType === 'lainnya'" x-collapse class="mt-4">
                                <textarea name="custom_complaint" rows="3" placeholder="Tuliskan keluhan atau kerusakan pada mobil Anda di sini..." class="w-full bg-gray-50 border border-gray-300 rounded-lg p-4 text-sm focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand focus:bg-white transition-colors"></textarea>
                                <p class="text-xs text-gray-400 mt-1 text-right">0/220 Karakter</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </section>

        <section :class="!vehicleSelected ? 'opacity-50 pointer-events-none' : ''">
            <h3 class="text-lg font-black text-ink uppercase tracking-tight mb-2 border-b-2 border-brand inline-block pb-1">PILIH CABANG & WAKTU</h3>
            <p class="text-sm text-gray-500 mb-6">Pilih lokasi bengkel dan waktu pengerjaan yang Anda inginkan.</p>

            <div class="bg-white border-2 border-gray-200 rounded-xl overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Lokasi Cabang</label>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <select name="branch" x-model="branch" required class="flex-1 bg-transparent border-none text-ink font-bold focus:ring-0 cursor-pointer outline-none">
                            <option value="" disabled selected>-- Pilih Cabang Terdekat --</option>
                            <option value="selatan">Wijaya Motor Jakarta Selatan</option>
                            <option value="pusat">Wijaya Motor Jakarta Pusat</option>
                        </select>
                    </div>
                </div>
                <div class="p-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Tanggal</label>
                        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 bg-gray-50">
                            <input type="date" name="date" x-model="date" required class="w-full bg-transparent border-none text-sm text-ink font-bold focus:ring-0 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Waktu</label>
                        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 bg-gray-50">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <select name="time" x-model="time" required class="w-full bg-transparent border-none text-sm text-ink font-bold focus:ring-0 outline-none cursor-pointer">
                                <option value="" disabled selected>-- Jam --</option>
                                <option value="08:00">08:00 WIB</option>
                                <option value="10:00">10:00 WIB</option>
                                <option value="13:00">13:00 WIB</option>
                                <option value="15:00">15:00 WIB</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </form>
</div>

<div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-30" x-show="vehicleSelected" x-transition.opacity>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
        
        <div class="flex-1 flex justify-between md:justify-start md:gap-16 w-full">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Estimasi Harga Jasa + Part</p>
                <p class="text-2xl font-black text-ink" x-text="formattedPrice"></p>
                <p class="text-[10px] text-gray-400 max-w-xs mt-1">*Harga di atas merupakan estimasi biaya servis. Harga aktual dapat berbeda saat pengecekan fisik.</p>
            </div>
            <div class="hidden md:block">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Estimasi Waktu Servis</p>
                <p class="text-lg font-black text-ink">1.5 - 2 Jam</p>
            </div>
        </div>

        <div class="w-full md:w-auto shrink-0 flex items-center justify-between md:justify-end gap-4">
            <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-12 h-12 rounded-full flex items-center justify-center transition" onclick="window.scrollTo(0,0)">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
            </button>
            <button type="submit" @click="document.querySelector('form').submit()" 
                    :class="(!branch || !date || !time) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-brand hover:bg-brand-dark text-white shadow-lg shadow-brand/20'" 
                    class="font-black px-10 py-4 rounded-xl transition-all uppercase tracking-wide flex-1 md:flex-none text-center">
                Konfirmasi Pesanan
            </button>
        </div>
    </div>
</div>

<div x-show="showDetailModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showDetailModal = false" x-transition.opacity></div>
    
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden relative z-10 flex flex-col max-h-[90vh]" 
         x-show="showDetailModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-8">
        
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 shrink-0">
            <h3 class="font-bold text-ink">SERVIS BERKALA</h3>
            <button @click="showDetailModal = false" class="text-gray-400 hover:text-gray-800 transition p-1">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-200 shrink-0">
            <button class="text-gray-400 hover:text-brand"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
            <span class="font-black text-brand text-sm tracking-widest" x-text="`SERVIS BERKALA ` + (kmSelected === '1000' ? '1 / 1.000' : (kmSelected === '10000' ? '2 / 10.000' : '3 / 20.000')) + ` KM`"></span>
            <button class="text-gray-400 hover:text-brand"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
        </div>

        <div class="flex bg-gray-100 p-2 m-6 rounded-lg shrink-0">
            <button @click="detailTab = 'diperiksa'" :class="detailTab === 'diperiksa' ? 'bg-ink text-white shadow-sm' : 'text-gray-500 hover:text-ink'" class="flex-1 py-2 text-sm font-bold rounded-md transition-colors">Part yang Diperiksa</button>
            <button @click="detailTab = 'diganti'" :class="detailTab === 'diganti' ? 'bg-ink text-white shadow-sm' : 'text-gray-500 hover:text-ink'" class="flex-1 py-2 text-sm font-bold rounded-md transition-colors">Part yang Diganti</button>
        </div>

        <div class="flex-1 overflow-y-auto px-6 pb-6">
            <ul x-show="detailTab === 'diperiksa'" class="space-y-4">
                <template x-for="item in ['Aki/Battery', 'Chasis Kendaraan', 'Freon AC', 'Kandungan Gas Buang', 'Klakson', 'Kondisi Ban', 'Kekencangan Baut', 'Lampu-Lampu', 'Minyak Power Steering', 'Oli Mesin', 'Pedal Kopling', 'Sistem Pengereman', 'Sistem Pendingin Mesin', 'Tali Kipas', 'Wiper & Washer']">
                    <li class="flex items-center text-sm font-medium text-gray-700">
                        <span class="w-1.5 h-1.5 bg-ink rounded-full mr-3"></span>
                        <span x-text="item"></span>
                    </li>
                </template>
            </ul>

            <div x-show="detailTab === 'diganti'" class="text-center py-10">
                <div x-show="kmSelected === '1000'">
                    <img src="https://cdn-icons-png.flaticon.com/512/814/814513.png" class="w-16 h-16 opacity-30 mx-auto mb-4" alt="No Part">
                    <h4 class="font-bold text-ink mb-2">Tidak Ada Part Diganti</h4>
                    <p class="text-sm text-gray-500 max-w-xs mx-auto">Servis berkala ini hanya mencakup pemeriksaan dan penyesuaian tanpa penggantian part.</p>
                </div>
                <div x-show="kmSelected !== '1000'" class="text-left space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <span class="text-sm font-medium text-gray-700 flex items-center"><span class="w-1.5 h-1.5 bg-brand rounded-full mr-3"></span>Oli Mesin TMO</span>
                        <span class="font-bold text-ink">Rp 450.000</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <span class="text-sm font-medium text-gray-700 flex items-center"><span class="w-1.5 h-1.5 bg-brand rounded-full mr-3"></span>Filter Oli Original</span>
                        <span class="font-bold text-ink">Rp 85.000</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <span class="text-sm font-medium text-gray-700 flex items-center"><span class="w-1.5 h-1.5 bg-brand rounded-full mr-3"></span>Gasket Carter</span>
                        <span class="font-bold text-ink">Rp 15.000</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>