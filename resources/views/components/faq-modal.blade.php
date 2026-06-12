<div x-data="{ faqOpen: false, activeFaq: null }" class="font-sans">
    {{-- Tombol FAQ (hidden, dipicu dari link footer) --}}
    <button @click="faqOpen = true" id="faq-trigger" class="hidden"></button>

    {{-- Overlay --}}
    <div x-show="faqOpen" 
         x-cloak
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="faqOpen = false"
         class="fixed inset-0 bg-black/50 z-50">
    </div>

    {{-- Modal --}}
    <div x-show="faqOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         @click.outside="faqOpen = false"
         class="fixed inset-4 sm:inset-auto sm:top-1/2 sm:left-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-[600px] bg-white rounded-2xl shadow-2xl z-50 flex flex-col overflow-hidden max-h-[calc(100vh-4rem)]">
        
        {{-- Header --}}
        <div class="bg-gradient-to-r from-brand to-red-600 px-6 py-5 text-white flex justify-between items-center shrink-0">
            <div>
                <h2 class="font-black text-lg uppercase tracking-wider">FAQ</h2>
                <p class="text-sm text-red-100 mt-0.5">Pertanyaan yang Sering Diajukan</p>
            </div>
            <button @click="faqOpen = false" class="text-white/80 hover:text-white transition p-1">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Daftar FAQ --}}
        <div class="flex-1 overflow-y-auto p-6 space-y-3">
            
            {{-- FAQ 1 --}}
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="activeFaq = activeFaq === 1 ? null : 1" 
                        class="w-full flex justify-between items-center px-5 py-4 text-left font-bold text-sm text-gray-900 hover:bg-gray-50 transition"
                        :class="activeFaq === 1 ? 'bg-gray-50' : ''">
                    <span>Bagaimana cara booking servis di Wijaya Motor?</span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0" 
                         :class="activeFaq === 1 ? 'rotate-180' : ''" 
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeFaq === 1" 
                     x-collapse
                     class="px-5 pb-4 text-sm text-gray-600 leading-relaxed">
                    <p>Caranya mudah! Klik menu "Booking Servis" di navigasi, lalu pilih tanggal dan jam yang diinginkan. Isi data kendaraan Anda, pilih layanan servis yang dibutuhkan, dan konfirmasi booking. Anda akan mendapatkan notifikasi konfirmasi melalui WhatsApp.</p>
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="activeFaq = activeFaq === 2 ? null : 2" 
                        class="w-full flex justify-between items-center px-5 py-4 text-left font-bold text-sm text-gray-900 hover:bg-gray-50 transition"
                        :class="activeFaq === 2 ? 'bg-gray-50' : ''">
                    <span>Apa saja metode pembayaran yang tersedia?</span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0" 
                         :class="activeFaq === 2 ? 'rotate-180' : ''" 
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeFaq === 2" 
                     x-collapse
                     class="px-5 pb-4 text-sm text-gray-600 leading-relaxed">
                    <p>Kami menerima pembayaran tunai, transfer bank (BCA, Mandiri, BRI), QRIS, dan E-Wallet (GoPay, OVO, Dana). Untuk pembayaran non-tunai, konfirmasi pembayaran akan diproses dalam 1x24 jam.</p>
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="activeFaq = activeFaq === 3 ? null : 3" 
                        class="w-full flex justify-between items-center px-5 py-4 text-left font-bold text-sm text-gray-900 hover:bg-gray-50 transition"
                        :class="activeFaq === 3 ? 'bg-gray-50' : ''">
                    <span>Berapa lama waktu pengerjaan servis?</span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0" 
                         :class="activeFaq === 3 ? 'rotate-180' : ''" 
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeFaq === 3" 
                     x-collapse
                     class="px-5 pb-4 text-sm text-gray-600 leading-relaxed">
                    <p>Waktu pengerjaan bervariasi tergantung jenis layanan. Servis ringan (ganti oli, filter) sekitar 1-2 jam. Servis besar dan perbaikan membutuhkan 3-6 jam atau lebih. Teknisi kami akan memberikan estimasi waktu yang lebih akurat saat pemeriksaan awal.</p>
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="activeFaq = activeFaq === 4 ? null : 4" 
                        class="w-full flex justify-between items-center px-5 py-4 text-left font-bold text-sm text-gray-900 hover:bg-gray-50 transition"
                        :class="activeFaq === 4 ? 'bg-gray-50' : ''">
                    <span>Apakah ada garansi untuk servis dan sparepart?</span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0" 
                         :class="activeFaq === 4 ? 'rotate-180' : ''" 
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeFaq === 4" 
                     x-collapse
                     class="px-5 pb-4 text-sm text-gray-600 leading-relaxed">
                    <p>Ya, kami memberikan garansi untuk setiap servis dan sparepart yang dibeli di Wijaya Motor. Garansi servis berlaku 30 hari atau 1.000 km (mana yang lebih dulu). Sparepart original memiliki garansi sesuai ketentuan pabrik. Syarat dan ketentuan berlaku.</p>
                </div>
            </div>

            {{-- FAQ 5 --}}
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="activeFaq = activeFaq === 5 ? null : 5" 
                        class="w-full flex justify-between items-center px-5 py-4 text-left font-bold text-sm text-gray-900 hover:bg-gray-50 transition"
                        :class="activeFaq === 5 ? 'bg-gray-50' : ''">
                    <span>Bagaimana cara membeli sparepart secara online?</span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0" 
                         :class="activeFaq === 5 ? 'rotate-180' : ''" 
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeFaq === 5" 
                     x-collapse
                     class="px-5 pb-4 text-sm text-gray-600 leading-relaxed">
                    <p>Kunjungi halaman Sparepart, pilih produk yang diinginkan, atur jumlah, dan klik "Beli" atau tambahkan ke keranjang. Setelah selesai berbelanja, lakukan checkout dan pilih metode pembayaran. Pesanan akan diproses setelah pembayaran dikonfirmasi.</p>
                </div>
            </div>

            {{-- FAQ 6 --}}
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="activeFaq = activeFaq === 6 ? null : 6" 
                        class="w-full flex justify-between items-center px-5 py-4 text-left font-bold text-sm text-gray-900 hover:bg-gray-50 transition"
                        :class="activeFaq === 6 ? 'bg-gray-50' : ''">
                    <span>Apakah Wijaya Motor melayani home service?</span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0" 
                         :class="activeFaq === 6 ? 'rotate-180' : ''" 
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeFaq === 6" 
                     x-collapse
                     class="px-5 pb-4 text-sm text-gray-600 leading-relaxed">
                    <p>Ya, Wijaya Motor melayani Home Service untuk area Tangerang dan sekitarnya. Layanan ini mencakup servis ringan seperti ganti oli, filter, dan pemeriksaan dasar. Silakan booking melalui menu "Home Service" di website kami.</p>
                </div>
            </div>

            {{-- FAQ 7 --}}
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="activeFaq = activeFaq === 7 ? null : 7" 
                        class="w-full flex justify-between items-center px-5 py-4 text-left font-bold text-sm text-gray-900 hover:bg-gray-50 transition"
                        :class="activeFaq === 7 ? 'bg-gray-50' : ''">
                    <span>Di mana lokasi bengkel Wijaya Motor?</span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0" 
                         :class="activeFaq === 7 ? 'rotate-180' : ''" 
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeFaq === 7" 
                     x-collapse
                     class="px-5 pb-4 text-sm text-gray-600 leading-relaxed">
                    <p>Wijaya Motor berlokasi di Jl. Aria Wangsakara, Bugel, Kec. Karawaci, Kota Tangerang, Banten 15114. Lihat halaman <a href="{{ route('lokasi') }}" class="text-danger font-bold hover:underline">Lokasi Bengkel</a> untuk informasi lebih detail dan petunjuk arah.</p>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="border-t border-gray-200 px-6 py-4 bg-gray-50 shrink-0">
            <p class="text-sm text-gray-500 text-center">
                Masih punya pertanyaan? 
                <a href="https://wa.me/62895321813103" target="_blank" class="text-danger font-bold hover:underline">Hubungi via WA</a>
                <span class="text-gray-300 mx-2">|</span>
                <a href="#" @click="faqOpen = false; setTimeout(() => document.getElementById('wira-ai-trigger')?.click(), 300)" class="text-brand font-bold hover:underline">Tanya Wira AI</a>
            </p>
        </div>
    </div>
</div>

{{-- Alpine.js Collapse plugin --}}
<script>
    // Alpine.js x-collapse sudah include via CDN di layout (AlpineJS v3)
</script>