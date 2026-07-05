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
        <p class="text-3xl font-black text-blue-500">{{ $confirmed }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Selesai & Lunas</p>
        <p class="text-3xl font-black text-green-500">{{ $done }}</p>
    </div>
</div>

{{-- Filter & Search --}}
<div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-sm mb-6 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
    @php 
        $currentStatus = $statusTab ?? request('status', 'pending'); 
        $currentDate = $filterDate ?? request('date');
    @endphp
    
    <!-- TABS -->
    <div class="flex bg-slate-100 p-1 rounded-xl border border-slate-200/80 shadow-inner overflow-x-auto">
        <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => 'all'])) }}" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all duration-200 {{ $currentStatus == 'all' ? 'bg-white text-danger shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200/60' }}">
            Semua
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => 'pending'])) }}" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all duration-200 flex items-center gap-1.5 {{ $currentStatus == 'pending' ? 'bg-white text-danger shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200/60' }}">
            <div class="w-1.5 h-1.5 rounded-full bg-orange-400"></div> Menunggu
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => 'confirmed'])) }}" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all duration-200 flex items-center gap-1.5 {{ $currentStatus == 'confirmed' ? 'bg-white text-danger shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200/60' }}">
            <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> Siap Diambil
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => 'done'])) }}" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all duration-200 flex items-center gap-1.5 {{ $currentStatus == 'done' ? 'bg-white text-danger shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200/60' }}">
            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Selesai & Lunas
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => 'cancelled'])) }}" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all duration-200 flex items-center gap-1.5 {{ $currentStatus == 'cancelled' ? 'bg-white text-danger shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200/60' }}">
            <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div> Dibatalkan
        </a>
    </div>

    <!-- SEARCH BAR -->
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-1 sm:flex-none gap-2">
        <input type="hidden" name="status" value="{{ $currentStatus }}">
        
        <input type="date" name="date" value="{{ $currentDate }}"
               class="w-full sm:w-auto text-xs font-medium border-slate-200 rounded-lg focus:ring-danger focus:border-danger py-2.5">
               
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari ID / Nama..."
               class="w-full sm:w-56 text-xs font-medium border-slate-200 rounded-lg focus:ring-danger focus:border-danger py-2.5">
        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-bold uppercase tracking-widest px-4 py-2.5 rounded-lg transition shadow-sm whitespace-nowrap">
            Cari
        </button>
        @if(request()->anyFilled(['search', 'date']) || (request()->has('date') && empty(request('date'))))
        <a href="{{ route('admin.orders.index', ['status' => $currentStatus, 'date' => '']) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold uppercase tracking-widest px-4 py-2.5 rounded-lg transition text-center whitespace-nowrap flex items-center">
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
                    <th class="text-left px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest w-16">No</th>
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
                <tr class="hover:bg-slate-50/50 transition group" x-data="{ confirmModal: false, cancelModal: false }">
                    <td class="px-5 py-4 text-xs font-bold text-slate-500">
                        {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-black text-slate-800 text-xs tracking-wider">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-bold text-slate-800">{{ $order->user->name ?? '-' }}</p>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $order->user->phone ?? '-' }}</p>
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
                        @if($order->status === 'done' && $order->payment_method)
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
                        @elseif($order->status === 'confirmed')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Siap Diambil
                            </span>
                        @elseif($order->status === 'done')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-green-50 text-green-700 border border-green-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                Lunas
                            </span>
                        @elseif($order->status === 'cancelled')
                            <div class="flex flex-col gap-1 items-start">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-100">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Dibatalkan
                                </span>
                                @if($order->cancel_reason)
                                    <span class="text-[9px] font-bold text-slate-500 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded leading-tight">{{ $order->cancel_reason }}</span>
                                @endif
                            </div>
                        @else
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-600">{{ $order->status }}</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-2">

                            {{-- Tombol Print Struk --}}
                            @if($order->status !== 'cancelled')
                            <a href="{{ route('admin.orders.struk', $order->id) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-black uppercase tracking-wider rounded-lg transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                Struk
                            </a>
                            @endif

                            {{-- STEP 1: Konfirmasi Order (hanya kalau pending) --}}
                            @if($order->status === 'pending')
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST"
                                      onsubmit="return confirm('Konfirmasi order ini? Barang akan disiapkan dan customer diberitahu untuk pickup.')">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Konfirmasi
                                    </button>
                                </form>
                                <button @click="cancelModal = true" type="button"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-100 hover:bg-rose-200 text-rose-700 text-[10px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                                    Tolak
                                </button>
                            </div>

                            {{-- MODAL TOLAK PESANAN --}}
                            <div x-show="cancelModal" x-cloak
                                 class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 text-left"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100">
                                <div @click.away="cancelModal = false"
                                     class="bg-white w-full max-w-sm rounded-2xl shadow-xl border border-slate-100 overflow-hidden"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100">

                                    <div class="p-6 border-b border-slate-100">
                                        <h3 class="font-black text-rose-600 text-base flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            Tolak Pesanan
                                        </h3>
                                        <p class="text-xs text-slate-500 mt-2">Pilih alasan pembatalan untuk order <strong>#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong>.</p>
                                    </div>

                                    <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="p-6 space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Alasan Penolakan</label>
                                            <div class="space-y-2">
                                                <label class="flex items-center gap-3 border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-rose-400 transition has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50">
                                                    <input type="radio" name="cancel_reason" value="Stok Fisik Habis / Rusak" class="accent-rose-600" required>
                                                    <span class="text-xs font-bold text-slate-800">Stok Fisik Habis / Rusak</span>
                                                </label>
                                                <label class="flex items-center gap-3 border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-rose-400 transition has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50">
                                                    <input type="radio" name="cancel_reason" value="Bengkel Sedang Tutup / Libur" class="accent-rose-600">
                                                    <span class="text-xs font-bold text-slate-800">Bengkel Sedang Tutup / Libur</span>
                                                </label>
                                                <label class="flex items-center gap-3 border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-rose-400 transition has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50">
                                                    <input type="radio" name="cancel_reason" value="Lainnya" class="accent-rose-600">
                                                    <span class="text-xs font-bold text-slate-800">Lainnya</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="flex gap-3 pt-2">
                                            <button type="button" @click="cancelModal = false"
                                                    class="flex-1 border border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider py-3 rounded-xl hover:bg-slate-50 transition">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                    class="flex-1 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold uppercase tracking-wider py-3 rounded-xl transition shadow-sm">
                                                Tolak Pesanan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif

                            {{-- STEP 2: Tandai Lunas (hanya kalau sudah confirmed / siap diambil) --}}
                            @if($order->status === 'confirmed')
                            <button @click="confirmModal = true"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-[10px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Tandai Lunas
                            </button>

                            {{-- MODAL TANDAI LUNAS --}}
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
                                        <h3 class="font-black text-slate-800 text-base">Tandai Lunas</h3>
                                        <p class="text-xs text-slate-500 mt-1">Order <strong>#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong> · {{ $order->user->name ?? '-' }}</p>
                                        <p class="text-sm font-black text-slate-800 mt-2">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                        <p class="text-[10px] text-slate-400 mt-1">Customer sudah pickup dan melakukan pembayaran.</p>
                                    </div>

                                    <form action="{{ route('admin.orders.mark.done', $order->id) }}" method="POST" class="p-6 space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Metode Pembayaran Customer</label>
                                            <div class="grid grid-cols-2 gap-3">
                                                <label class="flex items-center gap-2 border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-green-400 transition has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                                    <input type="radio" name="payment_method" value="cash" class="accent-green-600" required>
                                                    <div>
                                                        <p class="text-xs font-bold text-slate-800">Tunai</p>
                                                        <p class="text-[10px] text-slate-400">Bayar di kasir</p>
                                                    </div>
                                                </label>
                                                <label class="flex items-center gap-2 border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-green-400 transition has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                                    <input type="radio" name="payment_method" value="transfer" class="accent-green-600">
                                                    <div>
                                                        <p class="text-xs font-bold text-slate-800">Transfer</p>
                                                        <p class="text-[10px] text-slate-400">Via bank</p>
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
                                                Tandai Lunas
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
                    <td colspan="8" class="px-5 py-16 text-center">
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
