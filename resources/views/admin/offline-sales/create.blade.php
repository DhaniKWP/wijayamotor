@extends('layouts.admin')

@section('title', 'Transaksi Kasir Offline - Wijaya Motor')
@section('header_title', 'Transaksi Kasir Offline')

@section('content')

<div class="max-w-4xl mx-auto" x-data="kasirOffline()">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-5">
        <a href="{{ route('admin.offline-sales.index') }}" class="hover:text-brand transition-colors">Penjualan Offline</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-600">Transaksi Baru</span>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-100 text-red-700 px-4 py-3.5 rounded-xl mb-5 text-sm font-semibold">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.offline-sales.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Kolom Kiri: Form Kasir --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Info Customer --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                    <h2 class="text-sm font-extrabold text-slate-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Info Customer
                    </h2>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5">Nama Customer <span class="text-slate-300">(opsional)</span></label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                            placeholder="Kosongkan jika pelanggan umum / walk-in"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition placeholder:text-slate-300">
                    </div>
                </div>

                {{-- Pilih Sparepart --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            Item Sparepart
                        </h2>
                        <button type="button" @click="addRow()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand hover:bg-brand-dark text-white text-[11px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            Tambah Baris
                        </button>
                    </div>

                    <div class="space-y-3" id="item-rows">
                        <template x-for="(row, index) in rows" :key="index">
                            <div class="flex items-start gap-3 bg-slate-50 rounded-xl p-3 border border-slate-100">
                                {{-- Pilih Sparepart --}}
                                <div class="flex-1">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5">Sparepart</label>
                                    <select :name="`items[${index}][sparepart_id]`"
                                        @change="onSparepartChange($event, index)"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition bg-white">
                                        <option value="">-- Pilih Sparepart --</option>
                                        @foreach($spareparts as $sp)
                                        <option value="{{ $sp->id }}" data-price="{{ $sp->price }}" data-stock="{{ $sp->stock }}" data-name="{{ $sp->name }}">
                                            {{ $sp->name }} — Rp {{ number_format($sp->price, 0, ',', '.') }} (Stok: {{ $sp->stock }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Qty --}}
                                <div class="w-24">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5">Qty</label>
                                    <input type="number" :name="`items[${index}][qty]`"
                                        x-model.number="row.qty"
                                        @input="updateSubtotal(index)"
                                        :max="row.stock"
                                        min="1" placeholder="1"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm font-bold text-center text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
                                    <p class="text-[9px] text-slate-400 mt-1 text-center">Stok: <span x-text="row.stock"></span></p>
                                </div>

                                {{-- Subtotal --}}
                                <div class="w-36">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5">Subtotal</label>
                                    <div class="px-3 py-2 rounded-lg bg-white border border-slate-200 text-sm font-black text-slate-800 text-right">
                                        Rp <span x-text="formatRupiah(row.subtotal)"></span>
                                    </div>
                                </div>

                                {{-- Hapus --}}
                                <div class="pt-6">
                                    <button type="button" @click="removeRow(index)"
                                        x-show="rows.length > 1"
                                        class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <p x-show="rows.length === 0" class="text-center text-sm text-slate-400 py-6">
                        Klik "Tambah Baris" untuk memilih sparepart.
                    </p>
                </div>
            </div>

            {{-- Kolom Kanan: Ringkasan & Bayar --}}
            <div class="space-y-5">

                {{-- Metode Pembayaran --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                    <h2 class="text-sm font-extrabold text-slate-700 uppercase tracking-wider mb-4">Metode Pembayaran</h2>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="cash" class="sr-only peer" checked>
                            <div class="peer-checked:bg-emerald-50 peer-checked:border-emerald-400 peer-checked:text-emerald-700 border-2 border-slate-200 rounded-xl p-3 text-center transition-all">
                                <div class="text-2xl mb-1">💵</div>
                                <p class="text-xs font-black">Tunai</p>
                                <p class="text-[10px] text-slate-400">Bayar di kasir</p>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="transfer" class="sr-only peer">
                            <div class="peer-checked:bg-blue-50 peer-checked:border-blue-400 peer-checked:text-blue-700 border-2 border-slate-200 rounded-xl p-3 text-center transition-all">
                                <div class="text-2xl mb-1">🏦</div>
                                <p class="text-xs font-black">Transfer</p>
                                <p class="text-[10px] text-slate-400">Bank / e-wallet</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Ringkasan Total --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 sticky top-24">
                    <h2 class="text-sm font-extrabold text-slate-700 uppercase tracking-wider mb-4">Ringkasan</h2>
                    <div class="space-y-2 mb-4">
                        <template x-for="(row, index) in rows.filter(r => r.sparepart_id)" :key="index">
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-500 font-medium truncate flex-1 mr-2" x-text="row.name + ' ×' + row.qty"></span>
                                <span class="font-bold text-slate-700 shrink-0">Rp <span x-text="formatRupiah(row.subtotal)"></span></span>
                            </div>
                        </template>
                        <p x-show="rows.filter(r => r.sparepart_id).length === 0" class="text-xs text-slate-400 text-center py-2">Belum ada item dipilih</p>
                    </div>
                    <div class="border-t border-slate-100 pt-3 flex justify-between items-center">
                        <span class="text-sm font-extrabold text-slate-700 uppercase tracking-wider">TOTAL</span>
                        <span class="text-xl font-black text-brand">Rp <span x-text="formatRupiah(grandTotal)"></span></span>
                    </div>

                    <button type="submit"
                        class="mt-5 w-full inline-flex items-center justify-center gap-2 bg-brand hover:bg-brand-dark text-white py-3 rounded-xl text-sm font-black transition-all shadow-md hover:shadow-lg"
                        :disabled="grandTotal === 0"
                        :class="grandTotal === 0 ? 'opacity-50 cursor-not-allowed' : ''">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Selesaikan Penjualan
                    </button>

                    <a href="{{ route('admin.offline-sales.index') }}" class="mt-3 w-full inline-flex items-center justify-center gap-2 text-slate-500 hover:text-slate-700 text-sm font-bold transition-colors">
                        ← Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function kasirOffline() {
    return {
        rows: [{ sparepart_id: '', name: '', price: 0, qty: 1, subtotal: 0, stock: 0 }],

        get grandTotal() {
            return this.rows.reduce((sum, r) => sum + (r.subtotal || 0), 0);
        },

        addRow() {
            this.rows.push({ sparepart_id: '', name: '', price: 0, qty: 1, subtotal: 0, stock: 0 });
        },

        removeRow(index) {
            this.rows.splice(index, 1);
        },

        onSparepartChange(event, index) {
            const selected = event.target.options[event.target.selectedIndex];
            const price = parseFloat(selected.dataset.price || 0);
            const stock = parseInt(selected.dataset.stock || 0);
            const name  = selected.dataset.name || '';
            const id    = event.target.value;

            this.rows[index].sparepart_id = id;
            this.rows[index].price        = price;
            this.rows[index].stock        = stock;
            this.rows[index].name         = name;
            this.rows[index].qty          = 1;
            this.rows[index].subtotal     = price;
        },

        updateSubtotal(index) {
            const row = this.rows[index];
            let qty   = parseInt(row.qty) || 0;
            if (qty > row.stock) qty = row.stock;
            if (qty < 1) qty = 1;
            this.rows[index].qty      = qty;
            this.rows[index].subtotal = row.price * qty;
        },

        formatRupiah(val) {
            return (val || 0).toLocaleString('id-ID');
        }
    }
}
</script>

@endsection
