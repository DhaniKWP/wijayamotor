@extends('layouts.admin')

@section('title', 'Pesanan Sparepart — Admin Wijaya Motor')
@section('header_title', 'Pesanan Sparepart')

@section('content')

{{-- Alert --}}
@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2 shadow-sm">
    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

{{-- Stat Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Menunggu Konfirmasi</p>
        <p class="text-3xl font-black text-amber-500">{{ $pending }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Siap Diambil</p>
        <p class="text-3xl font-black text-blue-500">{{ $paid }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Selesai & Lunas</p>
        <p class="text-3xl font-black text-green-500">{{ $done }}</p>
    </div>
</div>

{{-- Filter & Search --}}
<div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm mb-6">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama customer / email / ID order..."
               class="flex-1 text-sm border-slate-200 rounded-lg focus:ring-brand focus:border-brand">
        <select name="status" class="text-sm border-slate-200 rounded-lg focus:ring-brand focus:border-brand sm:w-48">
            <option value="">Semua Status</option>
            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Menunggu Konfirmasi</option>
            <option value="done"     {{ request('status') === 'done'     ? 'selected' : '' }}>Selesai & Lunas</option>
        </select>
        <button type="submit" class="bg-ink hover:bg-ink/90 text-white text-xs font-bold uppercase tracking-widest px-5 py-2.5 rounded-lg transition shadow-sm whitespace-nowrap">
            Cari
        </button>
        @if(request()->anyFilled(['search','status']))
        <a href="{{ route('admin.orders.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase tracking-widest px-5 py-2.5 rounded-lg transition text-center whitespace-nowrap">
            Reset
        </a>
        @endif
    </form>
</div>

{{-- Tabel Orders --}}
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/80">
                    <th class="text-left px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Order</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Item</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Total</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="text-center px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($orders as $order)
                <tr class="hover:bg-slate-50/50 transition group" x-data="{ confirmModal: false }">
                    <td class="px-5 py-4">
                        <p class="font-black text-slate-800 text-xs tracking-wider">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-bold text-slate-800">{{ $order->user->name ?? '-' }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $order->user->email ?? '-' }}</p>
                    </td>
                    <td class="px-5 py-4 max-w-[200px]">
                        <div class="space-y-1">
                            @foreach($order->items as $item)
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-slate-100 rounded-md flex items-center justify-center shrink-0 overflow-hidden">
                                    @if($item->sparepart && $item->sparepart->image)
                                        <img src="{{ asset('uploads/spareparts/' . $item->sparepart->image) }}" class="w-full h-full object-cover" alt="">
                                    @else
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-700 truncate">{{ $item->sparepart->name ?? 'Produk dihapus' }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $item->qty }} pcs</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-black text-slate-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        @if($order->payment_method)
                            <p class="text-[10px] text-slate-400 mt-0.5 uppercase font-bold">{{ $order->payment_method === 'cash' ? 'Tunai' : 'Transfer' }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <p class="text-xs text-slate-600 font-medium">{{ $order->created_at->format('d M Y') }}</p>
                        <p class="text-[10px] text-slate-400">{{ $order->created_at->format('H:i') }} WIB</p>
                    </td>
                    <td class="px-5 py-4">
                        @if($order->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu
                            </span>
                        @elseif($order->status === 'done')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-green-50 text-green-700 border border-green-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                Lunas
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-600">{{ $order->status }}</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-2">

                            {{-- Tombol Print Struk --}}
                            <a href="{{ route('admin.orders.struk', $order->id) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-black uppercase tracking-wider rounded-lg transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                Struk
                            </a>

                            {{-- Tombol Tandai Lunas (hanya kalau pending) --}}
                            @if($order->status === 'pending')
                            <button @click="confirmModal = true"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-[10px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Tandai Lunas
                            </button>

                            {{-- MODAL KONFIRMASI --}}
                            <div x-show="confirmModal" x-cloak
                                 class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100">
                                <div @click.away="confirmModal = false"
                                     class="bg-white w-full max-w-sm rounded-2xl shadow-xl border border-slate-100 overflow-hidden"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100">
                                    
                                    <div class="p-6 border-b border-slate-100">
                                        <h3 class="font-black text-slate-800 text-base">Konfirmasi Pembayaran</h3>
                                        <p class="text-xs text-slate-500 mt-1">Order <strong>#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong> · {{ $order->user->name ?? '-' }}</p>
                                        <p class="text-sm font-black text-slate-800 mt-2">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </div>

                                    <form action="{{ route('admin.orders.mark.done', $order->id) }}" method="POST" class="p-6 space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Metode Pembayaran</label>
                                            <div class="grid grid-cols-2 gap-3">
                                                <label class="flex items-center gap-2 border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-green-400 transition has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                                    <input type="radio" name="payment_method" value="cash" class="accent-green-600" required>
                                                    <div>
                                                        <p class="text-xs font-bold text-slate-800">Tunai</p>
                                                        <p class="text-[10px] text-slate-400">Cash</p>
                                                    </div>
                                                </label>
                                                <label class="flex items-center gap-2 border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-green-400 transition has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                                    <input type="radio" name="payment_method" value="transfer" class="accent-green-600">
                                                    <div>
                                                        <p class="text-xs font-bold text-slate-800">Transfer</p>
                                                        <p class="text-[10px] text-slate-400">Bank</p>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="flex gap-3 pt-2">
                                            <button type="button" @click="confirmModal = false"
                                                    class="flex-1 border border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider py-3 rounded-xl hover:bg-slate-50 transition">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white text-xs font-bold uppercase tracking-wider py-3 rounded-xl transition shadow-sm">
                                                Konfirmasi Lunas
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center">
                        <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <p class="text-slate-400 text-sm font-medium">Belum ada pesanan sparepart masuk.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection
