@extends('layouts.app')

@section('title', 'Keranjang Belanja — Wijaya Motor')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-danger transition">Home</a>
        <span>&rsaquo;</span>
        <a href="{{ route('sparepart.index') }}" class="hover:text-danger transition">Aksesoris & Spareparts</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Keranjang</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-black uppercase text-gray-900 tracking-tight">KERANJANG <span class="text-danger">SAYA</span></h1>
        <p class="text-gray-500 text-sm mt-1">Selesaikan pesanan suku cadang dan aksesoris Anda.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm font-bold flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm font-bold flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    @if($cartItems->isEmpty())
        <div class="bg-white border border-gray-200 rounded-xl p-16 text-center shadow-sm">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"/>
                </svg>
            </div>
            <h2 class="text-xl font-black text-gray-900 mb-2">Keranjang Masih Kosong</h2>
            <p class="text-gray-500 text-sm mb-6 max-w-md mx-auto">Anda belum menambahkan produk apapun ke keranjang. Temukan suku cadang yang Anda butuhkan di katalog kami.</p>
            <a href="{{ route('sparepart.index') }}" class="inline-flex items-center bg-gray-900 hover:bg-black text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest transition shadow-sm">
                Belanja Sekarang
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start" x-data="cart()">
            
            {{-- Daftar Keranjang --}}
            <div class="lg:col-span-2 space-y-4">
                {{-- Pilih Semua --}}
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-center gap-4 cursor-pointer select-none" @click="toggleAll()">
                    <input type="checkbox" :checked="allSelected" class="w-5 h-5 text-danger rounded border-gray-300 focus:ring-danger pointer-events-none">
                    <span class="font-bold text-gray-900 text-sm">Pilih Semua</span>
                </div>

                @php $totalPrice = 0; @endphp
                @foreach($cartItems as $item)
                    @php 
                        $subtotal = $item->sparepart->price * $item->qty;
                        $totalPrice += $subtotal;
                    @endphp
                    <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6 shadow-sm flex flex-col sm:flex-row gap-6 relative">
                        {{-- Nomor --}}
                        <div class="absolute -top-3 -left-3 w-8 h-8 bg-gray-900 text-white font-black text-sm rounded-full flex items-center justify-center shadow-sm border-2 border-white z-10">
                            {{ $loop->iteration }}
                        </div>
                        
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="absolute top-4 right-4 sm:top-6 sm:right-6">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus barang ini dari keranjang?')" class="text-gray-400 hover:text-danger transition bg-gray-50 hover:bg-red-50 w-8 h-8 rounded-full flex items-center justify-center border border-gray-100 hover:border-red-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>

                        {{-- Checkbox & Gambar --}}
                        <div class="flex items-center gap-4 w-full sm:w-auto shrink-0">
                            <input type="checkbox" value="{{ $item->id }}" x-model="selectedIds" class="w-5 h-5 text-danger rounded border-gray-300 focus:ring-danger cursor-pointer">
                            <div class="flex-1 sm:w-28 h-28 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 overflow-hidden">
                            @if($item->sparepart->image)
                                <img src="{{ asset('uploads/spareparts/' . $item->sparepart->image) }}" alt="{{ $item->sparepart->name }}" class="object-cover w-full h-full">
                            @else
                                <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 pr-8 sm:pr-12 flex flex-col justify-between">
                            <div>
                                <a href="{{ route('sparepart.show', $item->sparepart_id) }}" class="font-bold text-gray-900 text-base lg:text-lg hover:text-danger transition line-clamp-2 pr-4 sm:pr-0">{{ $item->sparepart->name }}</a>
                                <p class="font-black text-danger mt-1">Rp {{ number_format($item->sparepart->price, 0, ',', '.') }}</p>
                                @if($item->sparepart->stock < $item->qty)
                                    <p class="text-xs text-red-500 font-bold mt-1 bg-red-50 inline-block px-2 py-0.5 rounded border border-red-100">Stok hanya tersisa {{ $item->sparepart->stock }} unit</p>
                                @elseif($item->sparepart->stock <= 5)
                                    <p class="text-xs text-amber-500 font-bold mt-1 bg-amber-50 inline-block px-2 py-0.5 rounded border border-amber-100">Sisa stok: {{ $item->sparepart->stock }} unit</p>
                                @endif
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                {{-- Kuantitas & Update --}}
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2" x-data="{ qty: {{ $item->qty }}, max: {{ $item->sparepart->stock }} }">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden h-9 w-28 bg-white">
                                        <button type="button" @click="if(qty > 1) qty--" class="w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-danger transition">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                        </button>
                                        <input type="number" name="qty" x-model="qty" min="1" :max="max" class="flex-1 text-center text-sm font-black text-gray-900 focus:outline-none focus:ring-0 border-0 p-0" readonly>
                                        <button type="button" @click="if(qty < max) qty++" class="w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-green-600 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        </button>
                                    </div>
                                    <button type="submit" class="text-[10px] font-bold text-gray-700 hover:text-white transition uppercase tracking-wider bg-gray-100 hover:bg-gray-900 px-3 py-2 rounded-lg border border-gray-200 hover:border-gray-900">Update</button>
                                </form>

                                <div class="text-right">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Subtotal</p>
                                    <p class="font-black text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Ringkasan --}}
            <div class="lg:col-span-1 bg-white border border-gray-200 rounded-xl shadow-sm p-6 sticky top-24">
                <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider mb-5 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-danger" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Ringkasan Pesanan
                </h2>

                <div class="space-y-3 text-sm text-gray-600 mb-6 border-b border-gray-100 pb-6">
                    <div class="flex justify-between">
                        <span>Total Item</span>
                        <span class="font-bold text-gray-900"><span x-text="totalItems"></span> Barang</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total Harga Barang</span>
                        <span class="font-bold text-gray-900" x-text="formatPrice"></span>
                    </div>
                    <div class="flex justify-between text-blue-600">
                        <span>Biaya Pickup</span>
                        <span class="font-bold">Gratis</span>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <span class="text-xs font-black text-gray-500 uppercase tracking-wider">Total Pembayaran</span>
                    <span class="text-2xl font-black text-danger" x-text="formatPrice"></span>
                </div>

                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="selected_items[]" :value="id">
                    </template>
                    <button type="submit" :disabled="selectedIds.length === 0" :class="selectedIds.length === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-black'" class="w-full bg-gray-900 text-white font-bold uppercase tracking-widest text-xs py-4 rounded-xl shadow-sm transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Checkout Sekarang
                    </button>
                </form>

                <div class="mt-4 bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start gap-3">
                    <svg class="w-4 h-4 text-gray-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-xs text-gray-500 leading-relaxed">Pastikan pesanan Anda sudah benar. Anda dapat mengambil barang langsung ke bengkel setelah proses checkout selesai.</p>
                </div>
            </div>

        </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('cart', () => ({
        items: @json($cartItems->map(fn($i) => ['id' => (string)$i->id, 'price' => $i->sparepart->price, 'qty' => $i->qty])),
        selectedIds: [],
        
        get totalItems() {
            return this.items.filter(i => this.selectedIds.includes(i.id)).reduce((sum, i) => sum + i.qty, 0);
        },
        get totalPrice() {
            return this.items.filter(i => this.selectedIds.includes(i.id)).reduce((sum, i) => sum + (i.price * i.qty), 0);
        },
        get formatPrice() {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(this.totalPrice);
        },
        get allSelected() {
            return this.selectedIds.length === this.items.length && this.items.length > 0;
        },
        toggleAll() {
            if (this.allSelected) {
                this.selectedIds = [];
            } else {
                this.selectedIds = this.items.map(i => i.id);
            }
        }
    }));
});
</script>
@endpush
