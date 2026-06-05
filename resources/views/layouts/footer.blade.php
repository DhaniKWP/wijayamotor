<footer class="bg-white border-t border-gray-200 pt-12 pb-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
      <div class="md:col-span-1">
        <a href="{{ url('/') }}" class="flex items-center gap-2 mb-4">
          <span class="font-black text-2xl tracking-tighter text-ink">WIJAYA<span class="text-danger border-b-4 border-brand leading-none inline-block pb-0.5">MOTOR</span></span>
        </a>
        <p class="text-sm text-gray-500 leading-relaxed">Penyedia layanan purna jual otomotif terlengkap. Mudah, cepat, dan terpercaya langsung dari genggaman Anda.</p>
      </div>
      <div>
        <h4 class="font-bold text-ink mb-4">Eksplor</h4>
        <ul class="space-y-2 text-sm text-gray-500">
          <li><a href="#" class="hover:text-brand">Promo</a></li>
          <li><a href="{{ route('booking.create') }}" class="hover:text-brand">Booking Servis</a></li>
          <li><a href="#" class="hover:text-brand">Suku Cadang</a></li>
          <li><a href="#" class="hover:text-brand">Home Service</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold text-ink mb-4">Dukungan</h4>
        <ul class="space-y-2 text-sm text-gray-500">
          <li><a href="#" class="hover:text-brand">Hubungi Kami</a></li>
          <li><a href="{{ route('lokasi') }}" class="hover:text-brand">Lokasi Bengkel</a></li>
          <li><a href="#" class="hover:text-brand">FAQ</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold text-ink mb-4">Unduh Aplikasi</h4>
        <div class="flex space-x-2">
          <div class="bg-gray-800 text-white px-3 py-1.5 rounded-md text-xs font-bold cursor-pointer hover:bg-gray-700">App Store</div>
          <div class="bg-gray-800 text-white px-3 py-1.5 rounded-md text-xs font-bold cursor-pointer hover:bg-gray-700">Google Play</div>
        </div>
      </div>
    </div>
    <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
      <p>© 2026 Wijaya Motor. Hak cipta dilindungi Undang-Undang.</p>
      <div class="flex space-x-4 mt-4 md:mt-0">
        <a href="#" class="hover:text-brand">Kebijakan Privasi</a>
        <a href="#" class="hover:text-brand">Syarat & Ketentuan</a>
      </div>
    </div>
  </div>
</footer>

<a href="#" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-white border border-gray-200 px-4 py-2.5 rounded-full shadow-xl hover:shadow-2xl hover:scale-105 transition-all group">
  <span class="font-bold text-sm text-ink group-hover:text-brand transition">Tanya AI Assistant</span>
  <div class="w-10 h-10 bg-brand rounded-full flex items-center justify-center text-white shadow-inner">
    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
  </div>
</a>