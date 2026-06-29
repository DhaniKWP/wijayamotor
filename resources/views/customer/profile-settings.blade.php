@extends('layouts.app')

@section('title', 'Pengaturan Profil — Wijaya Motor')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-200 py-3 sticky top-20 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-danger transition">Home</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Pengaturan Profil</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8">

    {{-- Sidebar --}}
    <aside class="lg:col-span-1 lg:sticky lg:top-36 self-start">
        <div class="mb-8">
            <p class="text-gray-500 text-sm">Halo,</p>
            <h2 class="text-xl font-black text-gray-900 leading-tight mb-2">{{ Auth::user()->name }}</h2>
            <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
        </div>
        <nav class="space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Dashboard Profil</a>
            <a href="{{ route('customer.pesanan') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Pesanan Saya</a>
            <a href="{{ route('garasi.index') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Garasi Saya</a>
            <a href="{{ route('booking.create') }}" class="flex items-center px-2 py-3 text-gray-600 hover:text-danger transition border-b border-gray-100 font-medium">Booking Baru</a>
            <a href="{{ route('customer.profile.settings') }}" class="flex items-center px-2 py-3 text-danger font-bold border-b border-gray-100">Pengaturan Profil</a>
            
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

    {{-- Main Content --}}
    <main class="lg:col-span-3">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-black uppercase text-gray-900 tracking-tight">PENGATURAN PROFIL</h2>
                <p class="text-gray-500 text-sm mt-1">Perbarui nama, nomor HP, dan alamat Anda di sini.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 text-sm font-bold border border-green-100 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 rounded-xl bg-amber-50 text-amber-700 text-sm font-bold border border-amber-100 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('info') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8">
                <form action="{{ route('customer.profile.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-bold text-gray-900 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition">
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-bold text-gray-500 mb-2">Email (Tidak dapat diubah)</label>
                        <input type="email" id="email" value="{{ $user->email }}" disabled
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                    </div>

                    <div class="mb-6">
                        <label for="phone" class="block text-sm font-bold text-gray-900 mb-2">Nomor WhatsApp / HP <span class="text-red-500">*</span></label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition"
                            placeholder="081234567890">
                        @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-8">
                        <label for="address" class="block text-sm font-bold text-gray-900 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea id="address" name="address" rows="3" required
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition"
                            placeholder="Jl. Raya Contoh No. 123">{{ old('address', $user->address) }}</textarea>
                        @error('address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-brand hover:bg-brand-dark text-white px-8 py-3 rounded-xl font-bold text-sm transition shadow-lg shadow-brand/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </main>
</div>

@endsection
