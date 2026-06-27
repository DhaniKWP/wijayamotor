@extends('layouts.app')

@section('title', $sparepart->name . ' — Wijaya Motor')

@section('content')
<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2 overflow-x-auto whitespace-nowrap">
        <a href="{{ url('/') }}" class="hover:text-danger transition">Home</a>
        <span>&rsaquo;</span>
        <a href="{{ route('sparepart.index') }}" class="hover:text-danger transition">Aksesoris & Spareparts</a>
        <span>&rsaquo;</span>
        <span class="text-ink truncate">{{ $sparepart->name }}</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ 
    qty: 1, 
    maxStock: {{ $sparepart->stock }},
    price: {{ $sparepart->price }},
    increment() { if(this.qty < this.maxStock) this.qty++; },
    decrement() { if(this.qty > 1) this.qty--; },
    get totalPrice() {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(this.price * this.qty);
    }
}">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm font-bold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm font-bold flex items-center">
            <svg class="w-5 h-5 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm flex flex-col md:flex-row">
        
        {{-- Gambar Produk --}}
        <div class="md:w-1/2 p-8 lg:p-12 flex items-center justify-center bg-gray-50 border-b md:border-b-0 md:border-r border-gray-200 relative">
            @if($sparepart->image)
                <img src="{{ asset('uploads/spareparts/' . $sparepart->image) }}" alt="{{ $sparepart->name }}" class="w-full max-w-md h-auto object-cover rounded-xl shadow-sm">
            @else
                <div class="w-full max-w-md aspect-square bg-gray-100 rounded-xl flex flex-col items-center justify-center border-2 border-dashed border-gray-200">
                    <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-xs text-gray-400 font-medium mt-3">Foto belum tersedia</p>
                </div>
            @endif

            @if($sparepart->stock <= 0)
                <div class="absolute inset-0 bg-white/75 backdrop-blur-sm flex items-center justify-center z-10">
                    <div class="bg-gray-900 text-white text-base font-black uppercase tracking-widest px-6 py-3 rounded-lg shadow-xl -rotate-12">STOK HABIS</div>
                </div>
            @endif
        </div>

        {{-- Detail & Form Pemesanan --}}
        <div class="md:w-1/2 p-8 lg:p-12 flex flex-col">
            
            {{-- Badge --}}
            <div class="mb-4">
                <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-black uppercase tracking-widest rounded border border-gray-200">Suku Cadang Resmi</span>
                @if($sparepart->stock > 0 && $sparepart->stock <= 5)
                    <span class="inline-block ml-2 px-3 py-1 bg-amber-50 text-amber-700 text-[10px] font-black uppercase tracking-widest rounded border border-amber-200">Stok Terbatas</span>
                @endif
            </div>
            
            <h1 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight mb-4">{{ $sparepart->name }}</h1>
            
            {{-- Harga & Stok --}}
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                <p class="text-3xl font-black text-danger">Rp {{ number_format($sparepart->price, 0, ',', '.') }}</p>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-8 flex-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Produk</p>
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $sparepart->description ?? 'Tidak ada deskripsi rinci untuk produk ini. Hubungi mekanik untuk kecocokan suku cadang dengan kendaraan Anda.' }}</p>
            </div>

            {{-- Info Pickup --}}
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <p class="text-xs font-bold text-blue-800">Pickup di Bengkel</p>
                    <p class="text-xs text-blue-600 mt-0.5">Sparepart dapat diambil langsung di bengkel Wijaya Motor setelah order dikonfirmasi.</p>
                </div>
            </div>

            {{-- Form Pemesanan --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                @if($sparepart->stock > 0)
                    @auth
                        @if(Auth::user()->role === 'customer')
                        <form action="{{ route('cart.add') }}" method="POST" class="space-y-5">
                            @csrf
                            <input type="hidden" name="sparepart_id" value="{{ $sparepart->id }}">
                            
                            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jumlah</label>
                                    <div class="flex items-center bg-white border border-gray-300 rounded-lg overflow-hidden h-11 w-36">
                                        <button type="button" @click="decrement()" class="w-10 shrink-0 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition bg-gray-50 border-r border-gray-200 font-black text-lg focus:outline-none">-</button>
                                        <input type="number" name="quantity" x-model="qty" readonly class="flex-1 min-w-0 w-full h-full text-center text-sm font-black text-gray-900 focus:outline-none bg-white">
                                        <button type="button" @click="increment()" class="w-10 shrink-0 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition bg-gray-50 border-l border-gray-200 font-black text-lg focus:outline-none">+</button>
                                    </div>
                                </div>
                                <div class="text-left sm:text-right">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total</p>
                                    <p class="text-xl font-black text-gray-900" x-text="totalPrice"></p>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-200">
                                <div class="grid grid-cols-2 gap-3">
                                    <button type="submit" formaction="{{ route('cart.add') }}" class="w-full bg-white border border-gray-900 text-gray-900 hover:bg-gray-50 font-bold uppercase tracking-widest text-xs py-3.5 rounded-xl transition flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                        Keranjang
                                    </button>
                                    <button type="submit" formaction="{{ route('customer.order.store') }}" class="w-full bg-gray-900 hover:bg-black text-white font-bold uppercase tracking-widest text-xs py-3.5 rounded-xl shadow-sm transition flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        Beli Langsung
                                    </button>
                                </div>
                                <p class="text-center text-[10px] text-gray-400 mt-3 font-medium">Beli banyak via keranjang, atau langsung checkout satu jenis barang</p>
                            </div>
                        </form>
                        @else
                            <p class="text-sm text-center text-gray-500 py-2">Pemesanan hanya untuk pelanggan terdaftar.</p>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full bg-gray-900 hover:bg-black text-white font-bold uppercase tracking-widest text-xs py-4 rounded-xl text-center transition">
                            Login untuk Memesan
                        </a>
                    @endauth
                @else
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="font-bold text-gray-900 mb-1 text-sm">Stok Sedang Kosong</p>
                        <p class="text-xs text-gray-500">Silakan cek kembali beberapa hari ke depan atau hubungi admin.</p>
                        <a href="{{ route('sparepart.index') }}" class="inline-block mt-4 text-xs font-bold text-danger hover:underline uppercase tracking-wider">Kembali ke Katalog &rarr;</a>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Produk lain --}}
    @if($related->count() > 0)
    <div class="mt-12">
        <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider mb-6">Produk Lainnya</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach($related as $item)
            <a href="{{ route('sparepart.show', $item->id) }}" class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition group block">
                <div class="bg-gray-50 aspect-square flex items-center justify-center p-4 border-b border-gray-100">
                    @if($item->image)
                        <img src="{{ asset('uploads/spareparts/' . $item->image) }}" alt="{{ $item->name }}" class="object-cover max-h-full max-w-full group-hover:scale-105 transition duration-300 rounded-lg">
                    @else
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    @endif
                </div>
                <div class="p-4">
                    <p class="text-xs font-bold text-gray-900 line-clamp-2 group-hover:text-danger transition mb-1">{{ $item->name }}</p>
                    <p class="text-sm font-black text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection