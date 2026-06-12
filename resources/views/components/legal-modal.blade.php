<div x-data="{ show: false, tab: 'privacy' }" class="font-sans">
    {{-- Hidden trigger --}}
    <button @click="show = true; tab = 'privacy'" id="privacy-trigger" class="hidden"></button>
    <button @click="show = true; tab = 'terms'" id="terms-trigger" class="hidden"></button>

    {{-- Overlay --}}
    <div x-show="show" 
         x-cloak
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="show = false"
         class="fixed inset-0 bg-black/50 z-50">
    </div>

    {{-- Modal --}}
    <div x-show="show"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         @click.outside="show = false"
         class="fixed inset-4 sm:inset-auto sm:top-1/2 sm:left-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-[600px] bg-white rounded-2xl shadow-2xl z-50 flex flex-col overflow-hidden max-h-[calc(100vh-4rem)]">
        
        {{-- Header --}}
        <div class="bg-gradient-to-r from-brand to-red-600 px-6 py-5 text-white flex justify-between items-center shrink-0">
            <div>
                <h2 class="font-black text-lg uppercase tracking-wider" x-text="tab === 'privacy' ? 'Kebijakan Privasi' : 'Syarat & Ketentuan'"></h2>
            </div>
            <button @click="show = false" class="text-white/80 hover:text-white transition p-1">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Tab Navigator --}}
        <div class="flex border-b border-gray-200 shrink-0">
            <button @click="tab = 'privacy'" 
                    class="flex-1 px-6 py-3.5 text-sm font-bold uppercase tracking-wider transition"
                    :class="tab === 'privacy' ? 'text-danger border-b-2 border-danger' : 'text-gray-400 hover:text-gray-600'">
                Kebijakan Privasi
            </button>
            <button @click="tab = 'terms'" 
                    class="flex-1 px-6 py-3.5 text-sm font-bold uppercase tracking-wider transition"
                    :class="tab === 'terms' ? 'text-danger border-b-2 border-danger' : 'text-gray-400 hover:text-gray-600'">
                Syarat & Ketentuan
            </button>
        </div>

        {{-- Content --}}
        <div class="flex-1 overflow-y-auto p-6">
            
            {{-- Kebijakan Privasi --}}
            <div x-show="tab === 'privacy'" class="space-y-4 text-sm text-gray-600 leading-relaxed">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <p class="text-blue-800 font-semibold text-xs">Terakhir diperbarui: 12 Juni 2026</p>
                </div>

                <h3 class="font-bold text-gray-900 text-base mt-6">1. Informasi yang Kami Kumpulkan</h3>
                <p>Kami mengumpulkan informasi pribadi yang Anda berikan secara sukarela saat menggunakan layanan Wijaya Motor, termasuk namun tidak terbatas pada:</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Nama lengkap dan data kontak (nomor telepon, email, alamat)</li>
                    <li>Data kendaraan (nomor polisi, merk, tipe, tahun)</li>
                    <li>Riwayat servis dan transaksi</li>
                    <li>Informasi pembayaran</li>
                </ul>

                <h3 class="font-bold text-gray-900 text-base mt-6">2. Penggunaan Informasi</h3>
                <p>Informasi yang kami kumpulkan digunakan untuk:</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Memproses booking servis dan pesanan sparepart</li>
                    <li>Memberikan notifikasi status servis</li>
                    <li>Meningkatkan kualitas layanan</li>
                    <li>Mengirim informasi promo dan tips perawatan (dengan persetujuan)</li>
                    <li>Keperluan administrasi dan pencatatan</li>
                </ul>

                <h3 class="font-bold text-gray-900 text-base mt-6">3. Perlindungan Data</h3>
                <p>Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk melindungi informasi pribadi Anda dari akses tidak sah, perubahan, pengungkapan, atau penghancuran.</p>

                <h3 class="font-bold text-gray-900 text-base mt-6">4. Hak Anda</h3>
                <p>Anda berhak untuk mengakses, memperbarui, atau menghapus data pribadi Anda. Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, silakan hubungi kami melalui WhatsApp atau email.</p>
            </div>

            {{-- Syarat & Ketentuan --}}
            <div x-show="tab === 'terms'" class="space-y-4 text-sm text-gray-600 leading-relaxed">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <p class="text-blue-800 font-semibold text-xs">Terakhir diperbarui: 12 Juni 2026</p>
                </div>

                <h3 class="font-bold text-gray-900 text-base mt-6">1. Layanan</h3>
                <p>Wijaya Motor menyediakan layanan booking servis, pembelian sparepart, dan home service. Dengan menggunakan layanan kami, Anda menyetujui syarat dan ketentuan yang berlaku.</p>

                <h3 class="font-bold text-gray-900 text-base mt-6">2. Booking Servis</h3>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Booking servis wajib dilakukan melalui website minimal H-1 sebelum kunjungan.</li>
                    <li>Pembatalan booking dapat dilakukan maksimal 2 jam sebelum jam booking.</li>
                    <li>Keterlambatan lebih dari 30 menit akan dianggap sebagai pembatalan sepihak.</li>
                    <li>Diskon 20% hanya berlaku untuk servis perdana melalui website.</li>
                </ul>

                <h3 class="font-bold text-gray-900 text-base mt-6">3. Pembelian Sparepart</h3>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Harga sparepart yang tertera adalah harga resmi dan dapat berubah sewaktu-waktu.</li>
                    <li>Pemesanan akan diproses setelah pembayaran dikonfirmasi.</li>
                    <li>Pengiriman sparepart hanya melayani area Tangerang dan sekitarnya.</li>
                    <li>Garansi sparepart sesuai ketentuan pabrik dan berlaku untuk produk original.</li>
                </ul>

                <h3 class="font-bold text-gray-900 text-base mt-6">4. Pembayaran</h3>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Pembayaran dapat dilakukan secara tunai di bengkel atau transfer bank.</li>
                    <li>Konfirmasi pembayaran non-tunai akan diproses dalam 1x24 jam.</li>
                    <li>Pengembalian dana (refund) diproses dalam 3-7 hari kerja sesuai kebijakan.</li>
                </ul>

                <h3 class="font-bold text-gray-900 text-base mt-6">5. Home Service</h3>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Home Service hanya melayani area Tangerang dan sekitarnya.</li>
                    <li>Biaya kunjungan akan ditambahkan ke total tagihan.</li>
                    <li>Layanan home service terbatas pada servis ringan.</li>
                </ul>

                <h3 class="font-bold text-gray-900 text-base mt-6">6. Ketentuan Lain</h3>
                <p>Wijaya Motor berhak mengubah syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya. Penggunaan layanan setelah perubahan dianggap sebagai persetujuan terhadap perubahan tersebut.</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="border-t border-gray-200 px-6 py-4 bg-gray-50 shrink-0">
            <div class="flex items-center justify-center gap-3">
                <button @click="tab = 'privacy'" class="text-xs text-danger font-bold hover:underline" :class="tab === 'privacy' ? 'underline' : ''">Kebijakan Privasi</button>
                <span class="text-gray-300">|</span>
                <button @click="tab = 'terms'" class="text-xs text-danger font-bold hover:underline" :class="tab === 'terms' ? 'underline' : ''">Syarat & Ketentuan</button>
            </div>
        </div>
    </div>
</div>