@extends('layouts.app')

@section('title', 'Lokasi Bengkel — Wijaya Motor')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-danger transition">Home</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Lokasi Bengkel</span>
    </div>
</div>

{{-- Page Header --}}
<div class="bg-white border-b border-gray-200 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-black uppercase text-gray-900 tracking-tight">LOKASI <span class="text-danger">BENGKEL</span></h1>
        <p class="text-gray-500 text-sm mt-2">Temukan kami di lokasi berikut. Kami siap melayani kendaraan Anda.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Info Kontak --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Nama & Alamat --}}
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-danger mr-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h2 class="font-black text-gray-900 text-sm uppercase tracking-wider">Alamat</h2>
                </div>
                <p class="text-gray-800 font-semibold leading-relaxed">Jl. RS. Fatmawati No.5</p>
                <p class="text-gray-500 text-sm mt-1">Cilandak Barat, Kec. Cilandak</p>
                <p class="text-gray-500 text-sm">Jakarta Selatan, DKI Jakarta 12430</p>
                <a href="https://maps.app.goo.gl/1dweiiuCgH6PBmNJ7" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="mt-4 inline-flex items-center text-xs font-bold text-danger hover:text-red-700 transition uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Buka di Google Maps
                </a>
            </div>

            {{-- Jam Operasional --}}
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-danger mr-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="font-black text-gray-900 text-sm uppercase tracking-wider">Jam Operasional</h2>
                </div>
                <ul class="space-y-2.5 text-sm">
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-gray-600 font-medium">Senin – Jumat</span>
                        <span class="font-bold text-gray-900">08.00 – 17.00</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-gray-600 font-medium">Sabtu</span>
                        <span class="font-bold text-gray-900">08.00 – 15.00</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Minggu & Libur</span>
                        <span class="font-bold text-danger">Tutup</span>
                    </li>
                </ul>
            </div>

            {{-- Kontak --}}
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-danger mr-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h2 class="font-black text-gray-900 text-sm uppercase tracking-wider">Kontak</h2>
                </div>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-3 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:+6221-7654321" class="text-gray-700 font-semibold hover:text-danger transition">(021) 765-4321</a>
                    </li>
                    <li class="flex items-center">
                        {{-- WhatsApp Icon --}}
                        <svg class="w-4 h-4 mr-3 text-gray-400 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <a href="https://wa.me/628123456789" target="_blank" rel="noopener noreferrer" class="text-gray-700 font-semibold hover:text-danger transition">+62 812-3456-789</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-3 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:info@wijayamotor.id" class="text-gray-700 font-semibold hover:text-danger transition">info@wijayamotor.id</a>
                    </li>
                </ul>
            </div>

            {{-- CTA Booking --}}
            <a href="{{ route('booking.create') }}" 
               class="flex items-center justify-center w-full bg-gray-900 hover:bg-black text-white px-5 py-3.5 rounded-xl font-bold text-sm uppercase tracking-widest transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Booking Sekarang
            </a>

        </div>

        {{-- Google Maps Embed --}}
        <div class="lg:col-span-2">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden h-full" style="min-height: 500px;">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="font-black text-gray-900 text-sm uppercase tracking-wider">Wijaya Motor</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Jl. RS. Fatmawati, Cilandak, Jakarta Selatan</p>
                    </div>
                    <a href="https://maps.app.goo.gl/1dweiiuCgH6PBmNJ7"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex items-center text-xs font-bold text-danger hover:text-red-700 transition uppercase tracking-wider border border-red-200 rounded-lg px-3 py-1.5 hover:bg-red-50">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Buka Maps
                    </a>
                </div>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.7461013984296!2d106.79479957460836!3d-6.290879993710856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f163591aabcb%3A0x30e95e0f19484d30!2sJl.%20RS.%20Fatmawati%2C%20Cilandak%20Bar.%2C%20Kec.%20Cilandak%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1717557600000!5m2!1sid!2sid"
                    width="100%"
                    height="100%"
                    style="border:0; min-height: 440px; display: block;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi Wijaya Motor di Google Maps">
                </iframe>
            </div>
        </div>

    </div>

    {{-- Cara Menuju Bengkel --}}
    <div class="mt-10 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider mb-5 flex items-center">
            <svg class="w-4 h-4 mr-2 text-danger" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
            Panduan Akses
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-start space-x-3">
                <div class="w-9 h-9 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-sm">Kendaraan Pribadi</p>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">Dari TB Simatupang, masuk ke Jl. RS. Fatmawati arah Blok M. Bengkel ada di sisi kiri jalan setelah RS. Fatmawati.</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="w-9 h-9 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-sm">Transportasi Umum</p>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">Gunakan MRT Jalur Lebak Bulus kemudian sambung ojek online. Atau naik Transjakarta koridor 8 turun di halte RS. Fatmawati.</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="w-9 h-9 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-sm">Area Parkir</p>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">Tersedia lahan parkir luas di depan bengkel. Kapasitas hingga 20 kendaraan roda empat dan area khusus motor.</p>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
