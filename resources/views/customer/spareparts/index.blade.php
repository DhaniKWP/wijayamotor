@extends('layouts.app')

@section('title', 'Aksesoris & Spareparts — Wijaya Motor')

@section('content')
<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-danger">Home</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Aksesoris & Spareparts</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-900 tracking-tight uppercase">AKSESORIS & SPAREPARTS</h1>
        <p class="text-gray-500 text-sm mt-1">Temukan suku cadang asli dan aksesoris resmi untuk kendaraan Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        
        <form action="{{ request()->url() }}" method="GET" class="space-y-5 bg-white p-5 rounded-xl border border-gray-200 shadow-sm lg:col-span-1">
            
            {{-- Cari Produk --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-700 mb-2">Cari Produk</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari oli, aki, ban..." 
                           class="w-full text-sm border-gray-200 rounded-xl pl-9 pr-4 py-2.5 focus:outline-none focus:border-danger focus:ring-2 focus:ring-danger/10 placeholder-gray-400 transition-all bg-white">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            {{-- Urutkan --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-700 mb-2">Urutkan</label>
                <div class="relative">
                    <select name="sort" class="w-full text-sm border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-danger focus:ring-2 focus:ring-danger/10 transition-all bg-white appearance-none cursor-pointer">
                        <option value="">Terbaru</option>
                        <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Nama: A - Z</option>
                        <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Nama: Z - A</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Rendah - Tinggi</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi - Rendah</option>
                    </select>
                    <svg class="w-4 h-4 text-gray-400 absolute right-3 top-3.5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-700 mb-2">Kategori</label>
                <div class="flex flex-wrap gap-1.5">
                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" 
                       class="px-3 py-1.5 text-xs font-bold rounded-lg border transition-all {{ !request('category') ? 'bg-danger border-danger text-white shadow-sm' : 'bg-gray-50 border-gray-200 text-gray-600 hover:border-gray-400 hover:bg-gray-100' }}">
                        Semua
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ request()->fullUrlWithQuery(['category' => $cat]) }}" 
                           class="px-3 py-1.5 text-xs font-bold rounded-lg border transition-all {{ request('category') == $cat ? 'bg-danger border-danger text-white shadow-sm' : 'bg-gray-50 border-gray-200 text-gray-600 hover:border-gray-400 hover:bg-gray-100' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                </div>
            </div>

            {{-- Kisaran Harga --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-700 mb-2">Kisaran Harga (Rp)</label>
                <div class="flex items-center gap-2">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" 
                           class="w-full text-sm border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-danger focus:ring-2 focus:ring-danger/10 placeholder-gray-400 transition-all bg-white">
                    <span class="text-gray-300 text-xs font-bold">—</span>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" 
                           class="w-full text-sm border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-danger focus:ring-2 focus:ring-danger/10 placeholder-gray-400 transition-all bg-white">
                </div>
            </div>

            {{-- Tombol --}}
            <div class="pt-1 space-y-2">
                <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white text-xs font-black uppercase tracking-widest py-3 rounded-xl transition shadow-sm hover:shadow-md">
                    Terapkan Filter
                </button>
                @if(request()->anyFilled(['search', 'sort', 'category', 'min_price', 'max_price']))
                    <a href="{{ route('sparepart.index') }}" class="block w-full text-center border border-gray-200 hover:border-gray-300 text-gray-600 hover:text-gray-800 text-xs font-bold uppercase tracking-wider py-3 rounded-xl transition">
                        Reset Filter
                    </a>
                @endif
            </div>
        </form>

        <div class="lg:col-span-3">
            @if($spareparts->isEmpty())
                <div class="bg-white border border-gray-200 rounded-xl p-12 text-center shadow-sm">
                    <p class="text-gray-400 text-sm italic">Produk tidak ditemukan atau tidak sesuai dengan kriteria filter.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($spareparts as $item)
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition flex flex-col justify-between group relative">
                            
                            <a href="{{ route('sparepart.show', $item->id) }}" class="absolute inset-0 z-30"></a>

                            <div>
                                <div class="bg-gray-50 aspect-square w-full flex items-center justify-center p-6 relative overflow-hidden border-b border-gray-100">
                                    @if($item->image)
                                        <img src="{{ asset('uploads/spareparts/' . $item->image) }}" alt="{{ $item->name }}" class="object-cover max-h-full max-w-full group-hover:scale-105 transition duration-300 rounded-lg">
                                    @else
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    @endif
                                    
                                    @if($item->stock <= 0)
                                        <div class="absolute inset-0 bg-white/80 flex items-center justify-center z-20">
                                            <span class="bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded">Stok Habis</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-5 relative z-20">
                                    <h3 class="font-bold text-gray-900 text-sm line-clamp-2 min-h-[40px] group-hover:text-danger transition">
                                        {{ $item->name }}
                                    </h3>
                                    <p class="text-xs text-gray-400 mt-1">Stok: {{ $item->stock }} item</p>
                                </div>
                            </div>

                            <div class="px-5 pb-5 pt-2 border-t border-gray-50 bg-gray-50/50 relative z-20">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Harga Resmi</p>
                                        <p class="font-black text-gray-900 text-base">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    
                                    <div class="bg-white group-hover:bg-danger text-gray-700 group-hover:text-white border border-gray-200 group-hover:border-danger p-2 rounded-lg transition shadow-sm pointer-events-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
@endsection