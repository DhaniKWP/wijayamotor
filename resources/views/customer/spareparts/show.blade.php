@extends('layouts.app')

@section('title', $sparepart->name . ' — Wijaya Motor')

@section('content')
<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2 overflow-x-auto whitespace-nowrap">
        <a href="{{ url('/') }}" class="hover:text-danger">Home</a>
        <span>&rsaquo;</span>
        <a href="{{ route('sparepart.index') }}" class="hover:text-danger">Aksesoris & Spareparts</a>
        <span>&rsaquo;</span>
        <span class="text-ink truncate">{{ $sparepart->name }}</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ 
    qty: 1, 
    maxStock: {{ $sparepart->stock }},
    price: {{ $sparepart->price }},
    
    increment() {
        if(this.qty < this.maxStock) this.qty++;
    },
    decrement() {
        if(this.qty > 1) this.qty--;
    },
    get totalPrice() {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(this.price * this.qty);
    }
}">
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm flex flex-col md:flex-row">
        
        <div class="md:w-1/2 p-8 lg:p-12 flex items-center justify-center bg-gray-50 border-b md:border-b-0 md:border-r border-gray-200 relative">
            @if($sparepart->image)
                <img src="{{ asset('uploads/spareparts/' . $sparepart->image) }}" alt="{{ $sparepart->name }}" class="w-full max-w-md h-auto object-cover rounded-xl shadow-lg">
            @else
                <div class="w-full max-w-md aspect-square bg-gray-100 rounded-xl flex items-center justify-center border-2 border-dashed border-gray-300">
                    <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            @if($sparepart->stock <= 0)
                <div class="absolute inset-0 bg-white/70 backdrop-blur-sm flex items-center justify-center z-10">
                    <div class="bg-gray-900 text-white text-xl font-black uppercase tracking-widest px-6 py-3 rounded-lg shadow-xl transform -rotate-12 border-4 border-gray-900">STOK HABIS</div>
                </div>
            @endif
        </div>

        <div class="md:w-1/2 p-8 lg:p-12 flex flex-col">
            <div class="mb-2">
                <span class="inline-block px-3 py-1 bg-green-50 text-green-700 text-[10px] font-black uppercase tracking-widest rounded mb-3 border border-green-200">Suku Cadang Asli (Genuine)</span>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight mb-4">{{ $sparepart->name }}</h1>
            
            <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-100">
                <p class="text-3xl font-black text-danger">Rp {{ number_format($sparepart->price, 0, ',', '.') }}</p>
                <div class="w-px h-8 bg-gray-200"></div>
                <p class="text-sm font-bold text-gray-500">Sisa Stok: <span class="{{ $sparepart->stock > 5 ? 'text-green-600' : 'text-red-500' }}">{{ $sparepart->stock }} Unit</span></p>
            </div>

            <div class="prose prose-sm text-gray-600 mb-8 flex-1">
                <p class="font-bold text-gray-900 uppercase text-xs tracking-wider mb-2">Deskripsi Produk</p>
                <p class="leading-relaxed whitespace-pre-line">{{ $sparepart->description ?? 'Tidak ada deskripsi rinci untuk produk ini. Hubungi mekanik untuk kecocokan suku cadang dengan kendaraan Anda.' }}</p>
            </div>

            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 mt-auto">
                @if($sparepart->stock > 0)
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="sparepart_id" value="{{ $sparepart->id }}">
                        
                        <div class="flex flex-col sm:flex-row gap-4 items-end sm:items-center justify-between">
                            <div class="w-full sm:w-auto">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Atur Jumlah</label>
                                <div class="flex items-center bg-white border border-gray-300 rounded-lg overflow-hidden h-12 w-32">
                                    <button type="button" @click="decrement()" class="w-10 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition focus:outline-none bg-gray-50 border-r border-gray-200 font-black text-lg">-</button>
                                    <input type="number" name="quantity" x-model="qty" readonly class="flex-1 w-full h-full text-center text-sm font-black text-gray-900 focus:outline-none select-none bg-white">
                                    <button type="button" @click="increment()" class="w-10 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition focus:outline-none bg-gray-50 border-l border-gray-200 font-black text-lg">+</button>
                                </div>
                            </div>

                            <div class="text-right w-full sm:w-auto border-t border-gray-200 sm:border-0 pt-4 sm:pt-0">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Harga</p>
                                <p class="text-xl font-black text-gray-900" x-text="totalPrice"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-4 border-t border-gray-200">
                            <button type="button" class="w-full border-2 border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white font-black uppercase tracking-widest text-xs py-4 rounded-xl transition flex items-center justify-center group">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Ke Keranjang
                            </button>
                            <button type="submit" class="w-full bg-danger hover:bg-red-700 text-white font-black uppercase tracking-widest text-xs py-4 rounded-xl shadow-lg transition flex items-center justify-center group">
                                Beli Langsung
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="font-bold text-gray-900 mb-1">Yah, Barang Sedang Kosong</p>
                        <p class="text-sm text-gray-500">Silakan cek kembali beberapa hari ke depan atau hubungi admin.</p>
                        <a href="{{ route('sparepart.index') }}" class="inline-block mt-4 text-xs font-bold text-danger uppercase tracking-wider hover:underline">Kembali ke Katalog</a>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection