@extends('layouts.admin')

@section('title', 'Transaksi Kasir Offline - Wijaya Motor')
@section('header_title', 'Kasir Offline')

@section('content')

<div x-data="kasirPOS()" class="flex gap-5 h-[calc(100vh-9rem)]">

    {{-- KIRI: Katalog Produk --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Search & Filter Bar --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-3 mb-4 shrink-0">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" x-model="search" placeholder="Cari nama sparepart..."
                    class="w-full pl-9 pr-4 py-2.5 rounded-lg border border-slate-200 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition placeholder:text-slate-300">
            </div>
        </div>

        {{-- Grid Katalog --}}
        <div class="overflow-y-auto flex-1 pr-1">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                @foreach($spareparts as $sp)
                <div
                    @click="addToCart({{ $sp->id }}, '{{ addslashes($sp->name) }}', {{ $sp->price }}, {{ $sp->stock }}, '{{ $sp->image ? asset('uploads/spareparts/' . $sp->image) : asset('images/no-image.png') }}')"
                    class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-brand/40 cursor-pointer transition-all duration-200 overflow-hidden group relative select-none"
                    :class="{{ $sp->stock }} === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:-translate-y-0.5 active:scale-95'"
                >
                    {{-- Badge Stok Habis --}}
                    @if($sp->stock === 0)
                    <div class="absolute inset-0 bg-white/70 flex items-center justify-center z-10 rounded-xl">
                        <span class="bg-red-100 text-red-600 text-[10px] font-black px-2 py-1 rounded-lg border border-red-200">STOK HABIS</span>
                    </div>
                    @endif

                    {{-- Badge Stok Sedikit --}}
                    @if($sp->stock > 0 && $sp->stock <= 5)
                    <div class="absolute top-2 right-2 z-10">
                        <span class="bg-amber-100 text-amber-700 text-[9px] font-black px-1.5 py-0.5 rounded-md border border-amber-200">Sisa {{ $sp->stock }}</span>
                    </div>
                    @endif

                    {{-- Gambar --}}
                    <div class="aspect-square bg-slate-50 overflow-hidden">
                        @if($sp->image)
                            <img src="{{ asset('uploads/spareparts/' . $sp->image) }}" alt="{{ $sp->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="p-2.5">
                        <p class="text-xs font-bold text-slate-800 leading-tight line-clamp-2 mb-1.5">{{ $sp->name }}</p>
                        <p class="text-sm font-black text-brand">Rp {{ number_format($sp->price, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">Stok: {{ $sp->stock }}</p>
                    </div>

                    {{-- Overlay klik --}}
                    @if($sp->stock > 0)
                    <div class="absolute inset-0 bg-brand/0 group-hover:bg-brand/5 rounded-xl transition-colors duration-200 flex items-center justify-center">
                        <div class="w-8 h-8 bg-brand text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200 shadow-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach

                {{-- Empty state saat search --}}
                <template x-if="search && filteredCount === 0">
                    <div class="col-span-full py-12 text-center text-slate-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <p class="text-sm font-bold">Sparepart tidak ditemukan</p>
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- KANAN: Keranjang / POS Panel --}}
    <div class="w-80 shrink-0 flex flex-col gap-3">

        {{-- Info Customer --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 shrink-0">
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5">Nama Customer</label>
            <input type="text" x-model="customerName" placeholder="Pelanggan Umum / Walk-in"
                class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition placeholder:text-slate-300">
        </div>

        {{-- Keranjang --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col flex-1 overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between shrink-0">
                <h3 class="text-sm font-extrabold text-slate-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Keranjang
                </h3>
                <span class="text-[10px] font-black bg-brand text-white px-2 py-0.5 rounded-full" x-text="cart.length + ' item'" x-show="cart.length > 0"></span>
            </div>

            {{-- List Item Keranjang --}}
            <div class="flex-1 overflow-y-auto px-3 py-2 space-y-2">
                <template x-if="cart.length === 0">
                    <div class="py-10 text-center text-slate-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <p class="text-xs font-bold">Klik produk untuk menambah</p>
                    </div>
                </template>

                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="flex items-center gap-2 bg-slate-50 rounded-lg p-2.5 border border-slate-100">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800 truncate" x-text="item.name"></p>
                            <p class="text-[10px] text-brand font-black" x-text="'Rp ' + formatRupiah(item.price)"></p>
                        </div>
                        {{-- Qty Controls --}}
                        <div class="flex items-center gap-1 shrink-0">
                            <button type="button" @click="decrement(index)"
                                class="w-6 h-6 rounded-lg bg-white border border-slate-200 text-slate-600 hover:border-red-300 hover:text-red-500 hover:bg-red-50 flex items-center justify-center transition font-black text-sm">−</button>
                            <span class="w-7 text-center text-xs font-black text-slate-800" x-text="item.qty"></span>
                            <button type="button" @click="increment(index)"
                                class="w-6 h-6 rounded-lg bg-white border border-slate-200 text-slate-600 hover:border-brand hover:text-brand hover:bg-red-50 flex items-center justify-center transition font-black text-sm">+</button>
                        </div>
                        {{-- Subtotal & Hapus --}}
                        <div class="text-right shrink-0">
                            <p class="text-xs font-black text-slate-700" x-text="'Rp ' + formatRupiah(item.price * item.qty)"></p>
                            <button type="button" @click="removeItem(index)" class="text-[10px] text-red-400 hover:text-red-600 font-bold mt-0.5">hapus</button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Total & Checkout --}}
            <div class="border-t border-slate-100 p-4 space-y-3 shrink-0">

                {{-- Grand Total --}}
                <div class="flex justify-between items-center">
                    <span class="text-sm font-extrabold text-slate-700 uppercase tracking-wide">Total</span>
                    <span class="text-xl font-black text-brand" x-text="'Rp ' + formatRupiah(grandTotal)"></span>
                </div>

                {{-- Metode Bayar --}}
                <div class="grid grid-cols-2 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" x-model="paymentMethod" value="cash" class="sr-only peer">
                        <div class="peer-checked:bg-emerald-50 peer-checked:border-emerald-400 peer-checked:text-emerald-700 border-2 border-slate-200 rounded-xl py-2 text-center transition-all">
                            <div class="text-lg">💵</div>
                            <p class="text-[10px] font-black mt-0.5">Tunai</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" x-model="paymentMethod" value="transfer" class="sr-only peer">
                        <div class="peer-checked:bg-blue-50 peer-checked:border-blue-400 peer-checked:text-blue-700 border-2 border-slate-200 rounded-xl py-2 text-center transition-all">
                            <div class="text-lg">🏦</div>
                            <p class="text-[10px] font-black mt-0.5">Transfer</p>
                        </div>
                    </label>
                </div>

                {{-- Tombol Selesai --}}
                <form :action="'{{ route('admin.offline-sales.store') }}'" method="POST" @submit.prevent="submitSale($el)">
                    @csrf
                    <input type="hidden" name="customer_name" :value="customerName">
                    <input type="hidden" name="payment_method" :value="paymentMethod">
                    <template x-for="(item, index) in cart" :key="item.id">
                        <span>
                            <input type="hidden" :name="`items[${index}][sparepart_id]`" :value="item.id">
                            <input type="hidden" :name="`items[${index}][qty]`" :value="item.qty">
                        </span>
                    </template>

                    <button type="submit"
                        :disabled="cart.length === 0"
                        :class="cart.length === 0 ? 'opacity-50 cursor-not-allowed bg-slate-300' : 'bg-brand hover:bg-brand-dark shadow-md hover:shadow-lg hover:-translate-y-0.5'"
                        class="w-full text-white py-3 rounded-xl text-sm font-black transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Selesaikan & Cetak Struk
                    </button>
                </form>

                {{-- Reset --}}
                <button type="button" @click="resetCart()" x-show="cart.length > 0"
                    class="w-full text-slate-400 hover:text-red-500 text-xs font-bold py-1 transition-colors">
                    🗑 Kosongkan Keranjang
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Search filter via JS --}}
<script>
function kasirPOS() {
    return {
        search: '',
        customerName: '',
        paymentMethod: 'cash',
        cart: [],
        filteredCount: {{ $spareparts->count() }},

        get grandTotal() {
            return this.cart.reduce((sum, item) => sum + item.price * item.qty, 0);
        },

        addToCart(id, name, price, stock, image) {
            if (stock <= 0) return;

            // Filter search
            const existing = this.cart.find(i => i.id === id);
            if (existing) {
                if (existing.qty < stock) {
                    existing.qty++;
                }
                return;
            }
            this.cart.push({ id, name, price, qty: 1, stock, image });
        },

        increment(index) {
            const item = this.cart[index];
            if (item.qty < item.stock) item.qty++;
        },

        decrement(index) {
            if (this.cart[index].qty > 1) {
                this.cart[index].qty--;
            } else {
                this.removeItem(index);
            }
        },

        removeItem(index) {
            this.cart.splice(index, 1);
        },

        resetCart() {
            Swal.fire({
                title: 'Kosongkan Keranjang?',
                text: "Semua item akan dihapus dari keranjang.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Kosongkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.cart = [];
                }
            });
        },

        submitSale(form) {
            if (this.cart.length === 0) return;
            
            Swal.fire({
                title: 'Selesaikan Penjualan?',
                html: `Total Belanja: <b class="text-brand text-lg">Rp ${this.formatRupiah(this.grandTotal)}</b><br><br>Pastikan item dan uang yang diterima sudah benar.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Selesaikan & Cetak!',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        },

        formatRupiah(val) {
            return (val || 0).toLocaleString('id-ID');
        }
    }
}

// Filter sparepart cards by search
document.addEventListener('alpine:init', () => {
    Alpine.effect(() => {
        // Filtering handled by CSS visibility via JS
    });
});

// Live search filter untuk card katalog
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[x-model="search"]');
    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.catalog-card').forEach(card => {
            const name = card.dataset.name.toLowerCase();
            card.style.display = name.includes(q) ? '' : 'none';
        });
    });
});
</script>

<style>
    /* Pastikan layout POS tidak overflow */
    main { overflow: hidden !important; }
</style>

@endsection
