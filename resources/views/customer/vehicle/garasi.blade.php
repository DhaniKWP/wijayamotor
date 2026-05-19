@extends('layouts.app')

@section('title', 'Garasi Saya — Wijaya Motor')

@section('content')
<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-danger transition">Home</a>
        <span>&rsaquo;</span>
        <a href="{{ route('dashboard') }}" class="hover:text-danger transition">Dashboard Profil</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Garasi Saya</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8" x-data="{ showAddModal: {{ $errors->any() ? 'true' : 'false' }} }">
    
    <aside class="lg:col-span-1">
        <div class="mb-8">
            <p class="text-gray-500 text-sm">Halo,</p>
            <h2 class="text-xl font-black text-gray-900 leading-tight mb-2">{{ Auth::user()->name }}</h2>
        </div>
        <nav class="space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Dashboard Profil</a>
            <a href="{{ route('garasi.index') }}" class="flex items-center px-2 py-3 text-danger font-bold border-b border-gray-100">Garasi Saya</a>
            <a href="{{ route('booking.create') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Booking Baru</a>
            
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">
                    Logout
                </a>
            </form>
        </nav>
    </aside>

    <main class="lg:col-span-3">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-black uppercase text-gray-900 tracking-tight">GARASI SAYA</h2>
                <p class="text-gray-500 text-sm mt-1">Kelola daftar kendaraan Anda untuk kemudahan booking servis.</p>
            </div>
            <button @click="showAddModal = true" class="bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-lg font-bold text-xs uppercase tracking-widest transition shadow-sm flex items-center shrink-0">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Tambah Kendaraan
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm font-bold flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($vehicles as $vehicle)
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition relative group flex flex-col justify-between">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center text-gray-400 group-hover:text-danger group-hover:bg-red-50 transition">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg leading-tight">{{ $vehicle->name }}</h3>
                                <p class="text-sm font-black text-danger tracking-widest mt-1">{{ $vehicle->plate_number }}</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('garasi.destroy', $vehicle->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kendaraan ini dari garasi?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-300 hover:text-danger p-1 transition">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center text-xs font-bold uppercase tracking-wider">
                        <span class="text-gray-500">Tahun: {{ $vehicle->year }}</span>
                        <span class="text-green-600 bg-green-50 px-2.5 py-1 rounded-md">Terdaftar</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 px-4 text-center border-2 border-dashed border-gray-200 rounded-xl bg-gray-50">
                    <div class="w-16 h-16 bg-white shadow-sm rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-gray-500 font-medium mb-3">Belum ada kendaraan di garasi Anda.</p>
                    <button @click="showAddModal = true" class="text-danger font-bold text-sm hover:underline">Tambah kendaraan pertama Anda &rarr;</button>
                </div>
            @endforelse
        </div>
    </main>

    <div x-show="showAddModal" 
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4">
        
        <div @click.away="showAddModal = false" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden flex flex-col">
            
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight">Daftarkan Kendaraan</h3>
                <button @click="showAddModal = false" class="text-gray-400 hover:text-danger transition bg-white rounded-full p-1 shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm border border-red-100 font-medium">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('garasi.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Nama / Merk Mobil</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Toyota Innova Reborn" 
                               class="w-full rounded-lg border-gray-300 px-4 py-3 text-sm focus:ring-danger focus:border-danger transition">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Nomor Plat</label>
                            <input type="text" name="plate_number" value="{{ old('plate_number') }}" required placeholder="B 1234 XYZ" 
                                   class="w-full rounded-lg border-gray-300 px-4 py-3 text-sm focus:ring-danger focus:border-danger transition uppercase">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Tahun</label>
                            <input type="number" name="year" value="{{ old('year', date('Y')) }}" required 
                                   class="w-full rounded-lg border-gray-300 px-4 py-3 text-sm focus:ring-danger focus:border-danger transition">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100 mt-6">
                        <button type="button" @click="showAddModal = false" class="px-5 py-2.5 text-xs font-black uppercase tracking-widest text-gray-500 hover:bg-gray-100 rounded-lg transition">Batal</button>
                        <button type="submit" class="bg-danger hover:bg-red-700 text-white px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-widest shadow-sm transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection